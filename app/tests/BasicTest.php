<?php

class BasicTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');

        $this->seed();
    }

    public function tearDown()
    {
        Artisan::call('cache:clear');
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isOk());
    }


}
