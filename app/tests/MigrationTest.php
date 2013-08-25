<?php

class MigrationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('migrate:refresh');

        $this->seed();
    }

    public function testMigrations()
    {
        // Stub test to ensure setup is called
        $this->assertTrue(true, 'Migration Up and Down test failed.');
    }
}
