<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('users')->delete();

        $user_first_name   = $faker->firstName;
        $user_last_name    = $faker->lastName;
        $user_display_name = "{$user_first_name} {$user_last_name}";

        Butler\Models\User::create(array(
            'email'        => 'blogger@butler.com',
            'password'     => 'password',
            'first_name'   => $user_first_name,
            'last_name'    => $user_last_name,
            'display_name' => $user_display_name,
            'url'          => $faker->url,
            'status'       => 'active'
        ));

        $status_types      = array('active', 'pending', 'trash', 'disabled');

        for($i = 1; $i < 10; $i++) {

            $user_first_name   = $faker->firstName;
            $user_last_name    = $faker->lastName;
            $user_display_name = "{$user_first_name} {$user_last_name}";

            Butler\Models\User::create(array(
                'email'        => $faker->email,
                'password'     => $user_display_name,
                'first_name'   => $user_first_name,
                'last_name'    => $user_last_name,
                'display_name' => $user_display_name,
                'url'          => $faker->url,
                'status'       => $status_types[rand(0, 3)]
            ));

        }

    }
}
