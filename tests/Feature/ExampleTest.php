<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;
use App\Domain\OrgMng\Emp\Emp;

use function PHPUnit\Framework\assertSame;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_should_save_entity()
    {
        $emp = new Emp();
        EntityManager::persist($emp);
        EntityManager::flush();

        $empFound = EntityManager::getRepository(Emp::class)->find($emp->getId());
        assertSame($emp->getId(), $empFound->getId());
    }
}
