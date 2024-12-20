<?php

namespace Tests;

use App\Repositories\UrlShortenerRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    protected UrlShortenerRepository $repository;
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function setUp():void
    {
        $this->repository = new UrlShortenerRepository();
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'UrlShortenerSeeder']);
    }

}
