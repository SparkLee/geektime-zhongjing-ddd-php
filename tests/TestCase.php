<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use LaravelDoctrine\ORM\Facades\EntityManager;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        EntityManager::beginTransaction();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        EntityManager::rollback();
    }
}
