<?php

use Way\Tests\Factory;
use Way\Tests\DataStore;

class UserTest extends TestCase
{
    use Way\Tests\ModelHelpers;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function testHashesPasswordWhenSet()
    {
        Hash::shouldReceive('make')->once()->andReturn('hashed');

        $user = new Butler\Models\User;
        $user->password = 'foo';

        $this->assertEquals('hashed', $user->password);
    }

    public function testValidateEmailValid()
    {
        $data_store = new DataStore;
        $input = array('email' => $data_store->getEmail());

        $this->assertTrue(
            Butler\Models\User::validator(
                $input,
                array_keys($input)
            )
        );
    }

    public function testValidateEmailInvalid()
    {
        $input = array('email' => 'peanut');

        $this->assertFalse(
            Butler\Models\User::validator(
                $input,
                array_keys($input)
            )
        );
    }

    public function testValidateUrlValid()
    {
        $input = array('url' => 'http://valid.domain.com');

        $this->assertTrue(
            Butler\Models\User::validator(
                $input,
                array_keys($input)
            )
        );
    }

    public function testValidateUrlInvalid()
    {
        $input = array('url' => 'peanut');

        $this->assertFalse(
            Butler\Models\User::validator(
                $input,
                array_keys($input)
            )
        );
    }

    public function testValidateStatus()
    {
        $valid_status = array(
            'active',
            'pending',
            'trash',
            'disabled',
        );

        $input = array(
            'status' => $valid_status[array_rand($valid_status, 1)]
        );

        $this->assertTrue(
            Butler\Models\User::validator(
                $input,
                array_keys($input)
            )
        );
    }

    public function testValidateStatusInvalid()
    {
        $input = array('status' => 'peanut');

        $this->assertFalse(
            Butler\Models\User::validator(
                $input,
                array_keys($input)
            )
        );
    }

    public function testValidUser()
    {
        $data_store = new DataStore;
        $user = Factory::make(
            'Butler\Models\User',
            array(
                'email'        => $data_store->getEmail(),
                'password'     => 'password',
                'first_name'   => $data_store->getName(),
                'last_name'    => $data_store->getName(),
                'display_name' => $data_store->getName(),
                'url'          => 'http://valid-domain.com',
                'status'       => 'active',
            )
        );

        $this->assertValid($user);
    }


    public function testNotValidUser()
    {
        $user = Factory::make(
            'Butler\Models\User',
            array(
                'email'  => 'foo',
                'url'    => 'bar',
                'status' => 'new-user',
            )
        );

        $this->assertNotValid($user);
    }
}
