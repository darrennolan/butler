<?php

/**
 * Use Classes
 */
use Illuminate\Console\Command;

class ImportWordpress extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import:wordpress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Wordpress Posts, Categories and Comments from a database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->info('WordPress Importer');
        $this->info("Please enter your wordpress database connection details.\n");

        Config::set(
            'database.connections.wordpress_import',
            array(
                'driver'   => 'mysql',
                'host'     => $this->ask("Hostname [localhost]:     ", 'localhost'),
                'database' => $this->ask("Database Name [blog_old]: ", 'blog_old'),
                'username' => $this->ask("Username [root]:          ", 'root'),
                'password' => $this->ask("Password []:              ", ''),
                'prefix'   => $this->ask("Table Prefix [wp_]:       ", 'wp_'),
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
            )
        );

        if ($this->confirm("\nThese details correct? [yes]|no? ", true)) {
            $this->import();
        } else {
            $this->info('Canceling.  fine... be that way....');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(

        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(

        );
    }

    private function import()
    {
        $this->user_mapping = array();
        $this->info('Importing Users...');
        $this->importUsers();

        $this->category_mapping = array();
        $this->info('Importing Categories...');
        $this->importCategories();

        $this->post_mapping = array();
        $this->info('Importing Posts...');
        $this->importPosts();

        $this->comment_mapping = array();
        $this->info('Importing Comments...');
        $this->importComments();

        $this->info('All Done. :)');
    }

    private function importUsers()
    {
        $wordpress_users = DB::connection('wordpress_import')->table('users')->get();

        foreach ($wordpress_users as $wordpress_user) {
            $user = new User();
            $user->email        = $wordpress_user->user_email;
            $user->password     = Hash::make($wordpress_user->user_email);
            $user->display_name = $wordpress_user->display_name;
            $user->url          = $wordpress_user->user_url;

            if ($user->save()) {
                $this->info(" - Added {$user->email}");
                $this->user_mapping[$wordpress_user->ID] = $user->id;
            } else {
                $this->info(" -- WARNING: Unable to add {$user->email}");
            }
        }
    }

    private function importCategories()
    {
        $wordpress_taxonomy = DB::connection('wordpress_import')->table('terms')
            ->join('term_taxonomy', 'term_taxonomy.term_id', '=', 'terms.term_id')
            ->where('term_taxonomy.taxonomy', '=', 'category')
            ->get();

        $categories = array();

        foreach ($wordpress_taxonomy as $wordpress_category) {
            $category = new Category();
            $category->name = $wordpress_category->name;

            if ($category->save()) {
                $this->info(" - Added {$category->name}");
                $this->category_mapping[$wordpress_category->term_id] = $category->id;

                // Categories with Parents need be stored to cycle through once we have all our category ids.
                if ($wordpress_category->parent != 0) {
                    $category->parent_id = $wordpress_category->parent;
                    $categories[] = $category;
                }

            } else {
                $this->info(" -- WARNING: Unable to add {$category->name}");
            }
        }

        // Link back our parent ids to real ids in our system
        foreach ($categories as $category) {
            $category->parent_id = $this->category_mapping[$category->parent_id];

            if ($category->save()) {
                $this->info(" - Linked {$category->name} to parent category");
            } else {
                $this->info(" -- WARNING: Unable to link {$category->name} to parent category");
            }
        }
    }

    private function importPosts()
    {
        $wordpress_posts = DB::connection('wordpress_import')->table('posts')
            ->where('post_type', '=', 'post')->get();

        foreach ($wordpress_posts as $wordpress_post) {
            $post = new Post();
            $post->user_id = $this->user_mapping[$wordpress_post->post_author];
            $post->title   = $wordpress_post->post_title;
            $post->content = $wordpress_post->post_content;
            $post->excerpt = $wordpress_post->post_excerpt;
            $post->post_at = $wordpress_post->post_date_gmt;

            switch ($wordpress_post->post_status) {
                case 'publish':
                    $post->status     = 'published';
                    $post->visibility = 'public';
                    break;

                case 'pending':
                    $post->status     = 'pending_review';
                    $post->visibility = 'public';
                    break;

                case 'draft':
                    $post->status     = 'draft';
                    $post->visibility = 'public';
                    break;

                case 'auto-draft':
                    $post->status     = 'draft';
                    $post->visibility = 'public';
                    break;

                case 'future':
                    $post->status     = 'published';
                    $post->visibility = 'public';
                    break;

                case 'private':
                    $post->status     = 'published';
                    $post->visibility = 'private';
                    break;

                case 'inherit':
                    $post->status     = 'published';
                    $post->visibility = 'public';
                    break;

                case 'trash':
                    $post->status     = 'trash';
                    $post->visibility = 'public';
                    break;
            }

            $post->allow_comments = ($wordpress_post->comment_status == 'open' ? true : false);

            if ($post->save()) {
                $this->info(" - Added {$post->title}");
                $this->post_mapping[$wordpress_post->ID] = $post->id;

                // Need to link this posts categories to the appropriate categories in our system
                $wordpress_post_categories = DB::connection('wordpress_import')->table('term_relationships')
                    ->join('term_taxonomy', 'term_taxonomy.term_taxonomy_id', '=', 'term_relationships.term_taxonomy_id')
                    ->join('terms', 'terms.term_id', '=', 'term_taxonomy.term_id')
                    ->where('term_taxonomy.taxonomy', '=', 'category')
                    ->where('term_relationships.object_id', '=', $wordpress_post->ID)
                    ->get();

                foreach ($wordpress_post_categories as $wordpress_category) {
                    $this->info(' -- linking to category ' . $wordpress_category->name);
                    $post->category()->attach($this->category_mapping[$wordpress_category->term_id]);
                }

            } else {
                $this->info(" -- WARNING: Unable to add {$post->title}");
            }
        }
    }

    private function importPostRevisions()
    {
        // Joining to the same table at this stage in Fluent not possible.  Doing raw-ish query. No idea why I'm not doing the whole thing raw
        $prefix = DB::connection('wordpress_import')->getTablePrefix();

        $wordpress_revisions = DB::connection('wordpress_import')
            ->table(DB::raw("{$prefix}posts AS {$prefix}revision"))
            ->select(DB::raw("{$prefix}revision.*"))
            ->join(DB::raw("{$prefix}posts AS {$prefix}revision_parent"), 'revision_parent.ID', '=',  'revision.post_parent')
            ->where('revision.post_type', '=', 'revision')
            ->where('revision_parent.post_type', '=', 'post')
            ->get();

        foreach ($wordpress_revisions as $wordpress_revision) {

            if (isset($this->post_mapping[$wordpress_revision->post_parent])) {

                $revision = new PostRevision();
                $revision->post_id = $this->post_mapping[$wordpress_revision->post_parent];
                $revision->user_id = $this->user_mapping[$wordpress_revision->post_author];
                $revision->title   = $wordpress_revision->post_title;
                $revision->content = $wordpress_revision->post_content;
                $revision->excerpt = $wordpress_revision->post_excerpt;

                if ($revision->save()) {
                    $this->info("- Added {$wordpress_revision->post_date_gmt}: {$revision->title}");

                    // Set "created_at" to Wordpress's original time.  Bit of a backwards way of doing shit.
                    $revision->created_at = $wordpress_revision->post_date_gmt;
                    $revision->save();
                } else {
                    $this->info(" -- WARNING: Unable to add {$revision->title}");
                }

            } else {
                $this->info(" -- SKIPPING: {$wordpress_revision->post_title} - Can't find his parent. Probably gone now.");
            }

        }
    }

    private function importPages()
    {
        $wordpress_pages = DB::connection('wordpress_import')->table('posts')
            ->where('post_type', '=', 'page')->get();

        foreach ($wordpress_pages as $wordpress_page) {
            $page = new Page();
            $page->user_id = $this->user_mapping[$wordpress_page->post_author];
            $page->title   = $wordpress_page->post_title;
            $page->content = $wordpress_page->post_content;
            $page->excerpt = $wordpress_page->post_excerpt;

            switch ($wordpress_page->post_status) {
                case 'publish':
                    $page->status     = 'published';
                    $page->visibility = 'public';
                    break;

                case 'pending':
                    $page->status     = 'pending_review';
                    $page->visibility = 'public';
                    break;

                case 'draft':
                    $page->status     = 'draft';
                    $page->visibility = 'public';
                    break;

                case 'auto-draft':
                    $page->status     = 'draft';
                    $page->visibility = 'public';
                    break;

                case 'future':
                    $page->status     = 'published';
                    $page->visibility = 'public';
                    break;

                case 'private':
                    $page->status     = 'published';
                    $page->visibility = 'private';
                    break;

                case 'inherit':
                    $page->status     = 'published';
                    $page->visibility = 'public';
                    break;

                case 'trash':
                    $page->status     = 'trash';
                    $page->visibility = 'public';
                    break;
            }

            if ($page->save()) {
                $this->info(" - Added {$page->title}");
                $this->page_mapping[$wordpress_page->ID] = $page->id;
            } else {
                $this->info(" -- WARNING: Unable to add {$page->title}");
            }
        }
    }

    private function importPageRevisions()
    {
        $prefix = DB::connection('wordpress_import')->getTablePrefix();

        $wordpress_revisions = DB::connection('wordpress_import')
            ->table(DB::raw("{$prefix}posts AS {$prefix}revision"))
            ->select(DB::raw("{$prefix}revision.*"))
            ->join(DB::raw("{$prefix}posts AS {$prefix}revision_parent"), 'revision_parent.ID', '=',  'revision.post_parent')
            ->where('revision.post_type', '=', 'revision')
            ->where('revision_parent.post_type', '=', 'page')
            ->get();

        foreach ($wordpress_revisions as $wordpress_revision) {

            if (isset($this->page_mapping[$wordpress_revision->post_parent])) {

                $revision = new PageRevision();
                $revision->page_id = $this->page_mapping[$wordpress_revision->post_parent];
                $revision->user_id = $this->user_mapping[$wordpress_revision->post_author];
                $revision->title   = $wordpress_revision->post_title;
                $revision->content = $wordpress_revision->post_content;
                $revision->excerpt = $wordpress_revision->post_excerpt;

                if ($revision->save()) {
                    $this->info("- Added {$wordpress_revision->post_date_gmt}: {$revision->title}");

                    // Set "created_at" to Wordpress's original time.  Bit of a backwards way of doing shit.
                    $revision->created_at = $wordpress_revision->post_date_gmt;
                    $revision->save();
                } else {
                    $this->info(" -- WARNING: Unable to add {$revision->title}");
                }

            } else {
                $this->info(" -- SKIPPING: {$wordpress_revision->post_title} - Can't find his parent. Probably gone now.");
            }

        }
    }

    private function importComments()
    {
        $wordpress_comments = DB::connection('wordpress_import')->table('comments')
            ->where('comment_type', '!=', 'pingback')
            ->get();

        $comments = array();

        foreach ($wordpress_comments as $wordpress_comment) {
            $comment = new Comment();
            $comment->post_id = $this->post_mapping[$wordpress_comment->comment_post_ID];

            if ($wordpress_comment->user_id == 0) {
                $comment->author_name  = $wordpress_comment->comment_author;
                $comment->author_email = $wordpress_comment->comment_author_email;
                $comment->author_url   = $wordpress_comment->comment_author_url;
                $comment->author_ip    = $wordpress_comment->comment_author_IP;
            } else {
                $comment->user_id      = $this->user_mapping[$wordpress_comment->user_id];
            }

            $comment->content = $wordpress_comment->comment_content;

            switch ($wordpress_comment->comment_approved) {
                case 0:
                    $comment->status = 'pending_review';
                    break;

                case 1:
                    $comment->status = 'approved';
                    break;

                // Need to confirm this is how trashed comments are marked in wordpress
                case 'trash':
                    $comment->status = 'trash';
                    break;

                case 'spam':
                    $comment->status = 'spam';
                    break;
            }


            if ($comment->save()) {
                $this->info(" - Added {$comment->id}");
                $this->comment_mapping[$wordpress_comment->comment_ID] = $comment->id;

                // Categories with Parents need be stored to cycle through once we have all our category ids.
                if ($wordpress_comment->comment_parent != 0) {
                    $comment->parent_id = $wordpress_comment->comment_parent;
                    $comments[] = $comment;
                }

            } else {
                $this->info(" -- WARNING: Unable to add {$wordpress_comment->comment_ID}");
            }
        }

        // Link back our parent ids to real ids in our system
        foreach ($comments as $comment) {
            $comment->parent_id = $this->comment_mapping[$comment->parent_id];

            if ($comment->save()) {
                $this->info(" - Linked {$comment->id} to {$comment->parent_id}");
            } else {
                $this->info(" -- WARNING: Unable to link {$comment->id} to parent comment");
            }
        }
    }

}
