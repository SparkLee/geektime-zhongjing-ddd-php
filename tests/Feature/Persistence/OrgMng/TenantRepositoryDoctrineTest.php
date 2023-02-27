<?php

namespace Persistence\OrgMng;

use App\Domain\TenantMng\Tenant;
use App\Domain\TenantMng\TenantRepository;
use App\Domain\TenantMng\TenantStatus;
use Carbon\Carbon;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class TenantRepositoryDoctrineTest extends TestCase
{
    private TenantRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(TenantRepository::class);
    }

    public function test_should_auto_set_CreatedAt_and_LastUpdatedAt()
    {
        // 1、创建时：自动生成创建时间和最后更新时间
        $tenant = new Tenant();
        EntityManager::persist($tenant);
        EntityManager::flush();
        $createdAt1 = $tenant->getCreatedAt();
        $lastUpdatedAt1 = $tenant->getLastUpdatedAt();
        self::assertNotNull($createdAt1);
        self::assertNotNull($lastUpdatedAt1);

        // 2、更新时：创建时间不变，最后更新时间自动变更为当前时间
        Carbon::setTestNow(Carbon::now()->addDay());

        $tenant->setStatus(TenantStatus::Ineffective);
        EntityManager::persist($tenant);
        EntityManager::flush();
        $createdAt2 = $tenant->getCreatedAt();
        $lastUpdatedAt2 = $tenant->getLastUpdatedAt();
        self::assertNotNull($createdAt2);
        self::assertNotNull($lastUpdatedAt2);
        self::assertSame($createdAt1->getTimestamp(), $createdAt2->getTimestamp());
        self::assertThat($lastUpdatedAt2->getTimestamp(), self::greaterThan($lastUpdatedAt1->getTimestamp()));

        Carbon::setTestNow(null);
    }
}
