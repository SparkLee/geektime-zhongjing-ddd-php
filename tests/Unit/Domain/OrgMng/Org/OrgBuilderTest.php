<?php

namespace Tests\Unit\Domain\OrgMng\Org;

use App\Domain\Common\Exceptions\BusinessException;
use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\OrgBuilder;
use App\Domain\OrgMng\OrgType\OrgTypeRepository;
use App\Domain\OrgMng\OrgType\OrgTypeStatus;
use App\Domain\TenantMng\Tenant;
use App\Domain\TenantMng\TenantRepository;
use App\Domain\TenantMng\TenantStatus;
use PHPUnit\Framework\TestCase;

class OrgBuilderTest extends TestCase
{
    private OrgDomainDTO $validOrgDomainDTO;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpRepositoryStubs();
        $this->setUpValidOrgDomainDTO();
    }

    /**
     * @return void
     */
    public function setUpRepositoryStubs(): void
    {
        app()->instance(TenantRepository::class, new TenantRepositoryStub());
        app()->instance(OrgTypeRepository::class, new OrgTypeRepositoryStub());
    }

    public function setUpValidOrgDomainDTO(): void
    {
        $this->validOrgDomainDTO = (new OrgDomainDTO())
            ->tenantId(1)
            ->superiorId(1)
            ->orgTypeCode('test')
            ->name('测试部门');
    }

    public function test_org_name_should_not_be_empty()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('组织名不能为空');

        $this->validOrgDomainDTO->name('');
        $this->build();
    }

    public function test_org_type_should_not_be_empty()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('组织类别不能为空！');

        $this->validOrgDomainDTO->orgTypeCode('');
        $this->build();
    }

    public function test_org_type_should_be_valid()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('[test]不是有效的组织类别代码！');

        app()->instance(OrgTypeRepository::class, (new OrgTypeRepositoryStub())
            ->setExistsByCodeAndStatus(false));

        $this->build();
    }

    public function test_org_type_should_not_create_enterprise_alone()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('企业是在创建租户的时候创建好的，因此不能单独创建企业!');

        $this->validOrgDomainDTO->orgTypeCode('ENTP');
        $this->build();
    }

    public function test_tenant_should_not_be_empty()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('租户不能为空');

        $this->validOrgDomainDTO->tenantId(0);
        $this->build();
    }

    public function test_tenant_should_be_effective()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('id为[1]的租户不是有效租户！');

        app()->instance(TenantRepository::class, (new TenantRepositoryStub())
            ->setExistsByIdAndStatus(false));

        $this->build();
    }

    public function makeOrgBuilder(): OrgBuilder
    {
        return app(OrgBuilder::class);
    }

    public function build(): void
    {
        $this->makeOrgBuilder()
            ->orgDomainDTO($this->validOrgDomainDTO)
            ->build();
    }
}

class TenantRepositoryStub implements TenantRepository
{
    private bool $existsByIdAndStatus = true;

    public function existsByIdAndStatus(int $tenantId, TenantStatus $tenantStatus): bool
    {
        return $this->existsByIdAndStatus;
    }

    public function setExistsByIdAndStatus(bool $existsByIdAndStatus): self
    {
        $this->existsByIdAndStatus = $existsByIdAndStatus;
        return $this;
    }
}

class OrgTypeRepositoryStub implements OrgTypeRepository
{
    private bool $existsByCodeAndStatus = true;

    public function existsByCodeAndStatus(Tenant|int $tenant, string $code, int|OrgTypeStatus $orgTypeStatus): bool
    {
        return $this->existsByCodeAndStatus;
    }

    public function setExistsByCodeAndStatus(bool $existsByCodeAndStatus): self
    {
        $this->existsByCodeAndStatus = $existsByCodeAndStatus;
        return $this;
    }
}
