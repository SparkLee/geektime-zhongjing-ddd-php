<?php

namespace Tests\Feature\Persistence\OrgMng;

use App\Domain\OrgMng\OrgType\OrgType;
use App\Domain\OrgMng\OrgType\OrgTypeRepository;
use App\Domain\OrgMng\OrgType\OrgTypeStatus;
use App\Domain\TenantMng\Tenant;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class OrgTypeRepositoryDoctrineTest extends TestCase
{
    private OrgTypeRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(OrgTypeRepository::class);
    }

    public function test_should_return_false_if_record_does_not_exist_with_given_code_and_status()
    {
        self::assertFalse($this->repository->existsByCodeAndStatus(1, 'DEVCENT', OrgTypeStatus::Effective));
    }

    public function test_should_return_true_if_record_exists_with_given_code_and_status()
    {
        $tenant = new Tenant();
        $orgType = new OrgType('DEVCENT', $tenant, '测试开发中心', OrgTypeStatus::Effective);
        EntityManager::persist($tenant);
        EntityManager::persist($orgType);
        EntityManager::flush();

        self::assertTrue($this->repository->existsByCodeAndStatus($tenant, 'DEVCENT', OrgTypeStatus::Effective->value));
        self::assertTrue($this->repository->existsByCodeAndStatus($tenant->getId(), 'DEVCENT', OrgTypeStatus::Effective));
    }
}
