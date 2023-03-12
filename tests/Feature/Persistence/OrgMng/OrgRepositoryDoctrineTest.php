<?php

namespace Persistence\OrgMng;

use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\Org;
use App\Domain\OrgMng\Org\OrgRepository;
use App\Domain\TenantMng\Tenant;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class OrgRepositoryDoctrineTest extends TestCase
{
    private OrgRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(OrgRepository::class);
    }

    public function test_should_find_by_id()
    {
        $tenant = new Tenant();
        EntityManager::persist($tenant);
        EntityManager::flush();

        $org = Org::fromOrgDomainDTO(
            (new OrgDomainDTO())
                ->tenant($tenant)
                ->name("foo")
                ->orgTypeCode("DEVCENT")
        );
        $this->repository->save($org);

        $foundOrg = $this->repository->findById($org->getId());
        self::assertInstanceOf(Org::class, $foundOrg);
    }
}
