<?php

class PostTableSeeder extends Seeder {

    public function run()
    {
        DB::table('posts')->delete();

        /**
         * User to Attach to
         */
        $user = Butler\Models\User::first();

        /**
         * Testing Posts
         */
        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing One';
        $post->content        = '<h4>Heading</h4><p>Just some testing text.</p><h4>Another Heading</h4><p>And some more text.</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Two';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Three';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Four';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Five';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Six';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Seven';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Eight';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Nine';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Ten';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);

        $post                 = new Butler\Models\Post;
        $post->title          = 'Post Title Testing Eleven';
        $post->content        = '<h4>Lorim Ipsum</h4><p>And some examples of a second post.</p><h4>Another Lorim</h4><p>Tada Tada Tada Tada Tada Tada .</p>';
        $post->excerpt        = null;
        $post->show_at        = new DateTime();
        $post->show_until     = null;
        $post->visibility     = 'public';
        $post->status         = 'published';
        $post->allow_comments = true;
        $post->is_page        = false;
        $user->posts()->save($post);
    }
}
