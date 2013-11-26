<?php

class PostTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('posts')->delete();

        /**
         * Testing Posts
         */
        $status = array('draft', 'pending_review', 'trash', 'published');
        for ($i = 1; $i < 100; $i++) {

            $user = Butler\Models\User::whereStatus('active')->orderBy(DB::raw('RAND()'))->first();

            $post                 = new Butler\Models\Post;
            $post->title          = $faker->sentence;

            $content = $faker->paragraphs( rand(3,20) );
            $content = array_map(function($element) {
                return "<p>{$element}</p>";
            }, $content);

            $post->content        = implode("\r\n", $content);
            $post->excerpt        = implode("\r\n", array_slice($content, 0, rand(1, 3)));
            $post->show_at        = $faker->dateTimeBetween('-1 years', 'now');
            $post->show_until     = null;
            $post->visibility     = 'public';
            $post->status         = ($faker->boolean(50) ? true : $status[rand(0, 2)]);
            $post->allow_comments = $faker->boolean(50);
            $post->is_page        = $faker->boolean(10);
            $user->posts()->save($post);

        }
    }
}
