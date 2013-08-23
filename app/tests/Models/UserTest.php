<?php

use Way\Tests\Factory;

class UserTest extends TestCase
{
    use Way\Tests\ModelHelpers;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');

        $this->seed();
    }

    public function testDummyToEnsureSetUpRuns()
    {
        $this->assertTrue(true);
    }

    public function testIsInvalidWithoutAValidEmail()
    {
        $user = Factory::make('Butler\Model\User', ['email' => 'test']);
        $this->assertNotValid($user);
    }
}
