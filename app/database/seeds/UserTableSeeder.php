<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        Butler\Models\User::create(array(
            'email'        => 'blogger@butler.com',
            'password'     => 'password',
            'first_name'   => 'Blog',
            'last_name'    => 'Man',
            'display_name' => 'Blogo',
        ));
    }
}
