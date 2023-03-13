<?php

namespace Tests\Feature\Http\Controllers\Restful\OrgMng;

use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\Org;
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
        $tenant = $testDataFactory->getTenant();
        $orgType = $testDataFactory->getOrgType();
        $superiorOrg = $testDataFactory->getSuperiorOrg();

        // When
        $response = $this->post('/api/organizations', [
            'tenant' => $tenant->getId(),
            'orgType' => $orgType->getCode(),
            'superior' => $superiorOrg->getId(),
            'name' => '上海金融开发中心',
        ]);
        var_dump($response->getContent());

        // Then
        $response->assertStatus(200);
        $response->assertJsonStructure(['id']);
        $response->assertJson([
            'tenant' => $tenant->getId(),
            'name' => '上海金融开发中心',
            'orgType' => 'DEVCENT',
            'superior' => $superiorOrg->getId(),
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
    private Tenant $tenant;
    private OrgType $orgType;
    private Org $superiorOrg;

    public static function make(): static
    {
        $factory = new static();
        $factory->makeTenant();
        $factory->makeOrgType();
        $factory->makeSuperiorOrg();
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

    public function makeSuperiorOrg(): void
    {
        $this->superiorOrg = Org::fromOrgDomainDTO((new OrgDomainDTO())
            ->tenant($this->tenant)
            ->name("中国卷卷通元宇宙集团")
            ->orgTypeCode("ENTP"));
    }

    public function persist(): void
    {
        EntityManager::persist($this->tenant);
        EntityManager::persist($this->orgType);
        EntityManager::persist($this->superiorOrg);
        EntityManager::flush();
    }

    public function getTenant(): Tenant
    {
        return $this->tenant;
    }

    public function getOrgType(): OrgType
    {
        return $this->orgType;
    }

    public function getSuperiorOrg(): Org
    {
        return $this->superiorOrg;
    }
}
