<?php

namespace Tests\Feature\Http\Controllers\Restful\OrgMng;

use App\Domain\OrgMng\OrgType\OrgType;
use App\Domain\OrgMng\OrgType\OrgTypeStatus;
use App\Domain\TenantMng\Tenant;
use App\Domain\TenantMng\TenantStatus;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class OrgControllerTest extends TestCase
{
    public function test_should_add_org()
    {
        // Given
        $tenant = (new Tenant())->setStatus(TenantStatus::Effective);
        $orgType = new OrgType('DEVCENT', $tenant, '开发中心', OrgTypeStatus::Effective);
        EntityManager::persist($tenant);
        EntityManager::persist($orgType);
        EntityManager::flush();

        // When
        $response = $this->post('/api/organizations', [
            'tenant' => $tenant->getId(),
            'name' => '上海金融开发中心',
            'orgType' => 'DEVCENT',
        ]);

        // Then
        $response->assertStatus(200);
        $response->assertJsonStructure(['id']);
        $response->assertJson([
            'tenant' => $tenant->getId(),
            'name' => '上海金融开发中心',
            'orgType' => 'DEVCENT',
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
