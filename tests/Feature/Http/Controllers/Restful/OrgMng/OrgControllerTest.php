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
        $testDataFactory = TestDataFactory::make();
        $tenant = $testDataFactory->tenant;

        // When
        $response = $this->post('/api/organizations', [
            'tenant' => $tenant->getId(),
            'name' => '上海金融开发中心',
            'orgType' => 'DEVCENT',
            'superior' => 1,
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

class TestDataFactory
{
    public Tenant $tenant;
    public OrgType $orgType;

    public static function make(): static
    {
        $factory = new static();
        $factory->makeTenant();
        $factory->makeOrgType();
        $factory->persist();
        return $factory;
    }

    public function makeTenant(): void
    {
        $this->tenant = (new Tenant())->setStatus(TenantStatus::Effective);
    }

    public function makeOrgType(): void
    {
        $this->orgType = new OrgType('DEVCENT', $this->tenant, '开发中心', OrgTypeStatus::Effective);
    }

    public function persist(): void
    {
        EntityManager::persist($this->tenant);
        EntityManager::persist($this->orgType);
        EntityManager::flush();
    }
}
