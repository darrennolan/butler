<?php

use Illuminate\Database\Migrations\Migration;

class BlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function($table) {
            $table->increments('id')->unsigned();               // Post ID.
            $table->integer('user_id')->unsigned();             // Author's ID.

            $table->string('title');                            // Post title
            $table->text('content')->nullable();                // Post Content
            $table->text('excerpt')->nullable();                // Short Excerpt for the post

            $table->datetime('post_at')->nullable();            // Where not null, post will display at this point in the future.
            $table->datetime('post_to')->nullable();            // Where not null, post will display until this point in the future.

            $table->enum('visibility',
                array('public', 'private')
            )->default('public');                               // Sets post's visibility
                                                                // Public - Everyone on the internet can see.
                                                                // Private - Just the authenticated users can see.

            $table->enum('status',
                array('draft', 'pending_review', 'trash', 'published')
            )->nullable();                                      // Defines if this post is ready to be displayed for viewing.
                                                                // Draft - saved, but not yet posted.
                                                                // Pending_review - Awaiting a user moderator to approve post.
                                                                // Trash - Pending full delete, kept for historical purposes. Not shown.
                                                                // Published - ready to be displayed to the world.

            $table->boolean('allow_comments')->default(true);   // If comments are allowed on this post.

            $table->boolean('is_page')->default(false);         // Flag to determine if post is to behave as a static page

            $table->timestamps();                               // created/updated at timestamps.

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('post_slugs', function($table) {
            $table->increments('id')->unsigned();       // Post ID.
            $table->integer('post_id')->unsigned();     // Author's ID.

            $table->string('url')->unique();            // URL

            $table->timestamps();                       // created/updated at timestamps.

            $table->foreign('post_id')->references('id')->on('posts')
                ->onDelete('cascade');
        });

        Schema::create('comments', function($table) {
            $table->increments('id')->unsigned();
            $table->integer('post_id')->unsigned();                     // Which post this comment is linked to
            $table->integer('parent_id')->unsigned()->nullable();       // Made under another comment?
            $table->integer('user_id')->unsigned()->nullable();         // Made by a registered user?

            $table->string('author_name')->nullable();                  // Author's Name (if not registered user)
            $table->string('author_email')->nullable();                 // Author's Email (if not registered user)
            $table->string('author_url')->nullable();                   // Author's URL (if not registered user)
            $table->string('author_ip')->nullable();                    // Author's IP address (if not registered user)

            $table->text('content');                                    // Comment Content.

            $table->enum('status',
                array('pending_review', 'spam', 'trash', 'approved')
            )->default('pending_review');                               // Status of this comment.
                                                                        // pending_review - Awaiting moderation
                                                                        // spam - Marked as spam by moderator.
                                                                        // trash - Marked as trash by moderator
                                                                        // approved - Approved for public consumption. Om nom.

            $table->timestamps();                                       // created/updated at timestamps.

            $table->foreign('post_id')->references('id')->on('posts')
                ->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('categories', function($table) {
            $table->increments('id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();

            $table->string('name');

            $table->timestamps();                       // created/updated at timestamps

            $table->unique(array('name', 'parent_id'));

            $table->foreign('parent_id')->references('id')->on('categories')
                ->onDelete('cascade');
        });

        Schema::create('category_post', function ($table) {
            $table->integer('category_id')->unsigned();
            $table->integer('post_id')->unsigned();

            $table->timestamps();

            $table->primary(array('category_id', 'post_id'));

            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')
                ->onDelete('cascade');
        });

        Schema::create('settings', function($table) {
            $table->increments('id')->unsigned();
            $table->string('name');                 // Site Option Name
            $table->string('value');                // Site Option Value

            $table->timestamps();                   // created/updated at timestamps
        });

        Schema::create('revisions', function($table) {
            $table->increments('id')->unsigned();   // Revision Id
            $table->integer('post_id')->unsigned(); // Post Id
            $table->text('post_data');              // JSON encoded data of post record

            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');

        Schema::table('revisions', function($table) {
            $table->dropForeign('revisions_post_id_foreign');
        });
        Schema::drop('revisions');

        Schema::table('category_post', function ($table) {
            $table->dropForeign('category_post_post_id_foreign');
            $table->dropForeign('category_post_category_id_foreign');
            $table->dropPrimary('category_id_post_id_primary');
        });
        Schema::drop('category_post');

        Schema::table('categories', function ($table) {
            $table->dropForeign('categories_parent_id_foreign');
        });
        Schema::drop('categories');

        Schema::table('comments', function($table) {
            $table->dropForeign('comments_user_id_foreign');
            $table->dropForeign('comments_parent_id_foreign');
            $table->dropForeign('comments_post_id_foreign');
        });
        Schema::drop('comments');

        Schema::table('post_slugs', function($table) {
            $table->dropForeign('post_slugs_post_id_foreign');
        });
        Schema::drop('post_slugs');

        Schema::table('posts', function($table) {
            $table->dropForeign('posts_user_id_foreign');
        });
        Schema::drop('posts');
    }

}
