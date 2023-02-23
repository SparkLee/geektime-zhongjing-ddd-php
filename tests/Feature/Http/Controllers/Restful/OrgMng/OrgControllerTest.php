<?php

namespace Tests\Feature\Http\Controllers\Restful\OrgMng;

use App\Domain\TenantMng\Tenant;
use App\Domain\TenantMng\TenantStatus;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class OrgControllerTest extends TestCase
{
    public function test_should_add_org()
    {
        // Given
        $tenant = (new Tenant())
            ->setStatus(TenantStatus::Effective->value);
        EntityManager::persist($tenant);
        EntityManager::flush();

        // When
        $response = $this->post('/api/organizations', [
            'tenantId' => $tenant->getId(),
            'name' => 'foo',
        ]);

        // Then
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'tenantId']);
        $response->assertJson([
            'tenantId' => $tenant->getId(),
            'name' => 'foo',
        ]);
    }

    public function test_should_update_org_basic_info()
    {
        $response = $this->put('/api/organizations/1/basic_info', [
            'tenantId' => 1
        ]);

        $response->assertStatus(200);
    }
}
