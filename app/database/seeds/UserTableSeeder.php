<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $password = Hash::make('password');

        User::create(array(
            'email' => 'blogger@butler.com',
            'password' => $password,
            'first_name' => 'Blog',
            'last_name' => 'Man',
            'display_name' => 'Blogo',
        ));
    }
}
