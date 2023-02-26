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

    /**
     * @see https://www.doctrine-project.org/2022/01/11/orm-2.11.html
     */
    public function test_virtual_and_generated_columns()
    {
        // 1、新增
        $tenant = new Tenant();
        $orgType = new OrgType('DEVCENT', $tenant, 'foo', OrgTypeStatus::Effective);
        EntityManager::persist($tenant);
        EntityManager::persist($orgType);
        EntityManager::flush();
        $createdAt1 = $orgType->getCreatedAt();
        $lastUpdatedAt1 = $orgType->getLastUpdatedAt();

        // 2、等待一秒
        sleep(1);

        // 3、更新
        $orgType->setName('bar');
        EntityManager::flush();
        $createdAt2 = $orgType->getCreatedAt();
        $lastUpdatedAt2 = $orgType->getLastUpdatedAt();

        // 4、更新记录后，创建时间不变，更新时间自动变更
        self::assertSame($createdAt1->getTimestamp(), $createdAt2->getTimestamp());
        self::assertThat($lastUpdatedAt2->getTimestamp(), self::greaterThan($lastUpdatedAt1->getTimestamp()));
    }
}
