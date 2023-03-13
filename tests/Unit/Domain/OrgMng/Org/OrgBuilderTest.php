<?php

namespace Tests\Unit\Domain\OrgMng\Org;

use App\Domain\Common\Exceptions\BusinessException;
use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\OrgBuilder;
use App\Domain\OrgMng\Org\OrgRepository;
use App\Domain\OrgMng\OrgType\OrgTypeRepository;
use App\Domain\TenantMng\Tenant;
use App\Domain\TenantMng\TenantRepository;
use App\Domain\TenantMng\TenantStatus;
use PHPUnit\Framework\TestCase;

class OrgBuilderTest extends TestCase
{
    private TestDataFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = TestDataFactory::make();
        $this->setUpRepositoryStubs();
    }

    /**
     * @return void
     *
     * 注意：$this->createStub() 的返回值要先赋值给一个局部变量，比如 $stub, 然后再使用 $stub->method()->willReturn()，否则返回的类型将不是预期的类型，会报类似这样的错误：
     * "Argument #1 ($tenantRepository) must be of type App\Domain\TenantMng\TenantRepository, PHPUnit\Framework\MockObject\Builder\InvocationMocker given"
     * @see https://github.com/sebastianbergmann/phpunit/issues/3706#issuecomment-513094256
     */
    public function setUpRepositoryStubs(): void
    {
        $tenantRepositoryStub = $this->createStub(TenantRepository::class);
        $tenantRepositoryStub->method('findById')->willReturn(($this->factory->getTenant()));
        app()->instance(TenantRepository::class, $tenantRepositoryStub);

        $orgRepository = $this->createStub(OrgRepository::class);
        app()->instance(OrgRepository::class, $orgRepository);

        $orgTypeRepositoryStub = $this->createStub(OrgTypeRepository::class);
        $orgTypeRepositoryStub->method('existsByCodeAndStatus')->willReturn(true);
        app()->instance(OrgTypeRepository::class, $orgTypeRepositoryStub);
    }

    public function test_org_name_should_not_be_empty()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('组织名不能为空');

        $this->factory->getValidOrgDomainDTO()->name('');
        $this->build();
    }

    public function test_org_type_should_not_be_empty()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('组织类别不能为空！');

        $this->factory->getValidOrgDomainDTO()->orgTypeCode('');
        $this->build();
    }

    public function test_org_type_should_be_valid()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('[test]不是有效的组织类别代码！');

        $orgTypeRepositoryStub = $this->createStub(OrgTypeRepository::class);
        self::assertInstanceOf(OrgTypeRepository::class, $orgTypeRepositoryStub);
        $orgTypeRepositoryStub->method('existsByCodeAndStatus')->willReturn(false);
        app()->instance(OrgTypeRepository::class, $orgTypeRepositoryStub);

        $this->build();
    }

    public function test_org_type_should_not_create_enterprise_alone()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('企业是在创建租户的时候创建好的，因此不能单独创建企业!');

        $this->factory->getValidOrgDomainDTO()->orgTypeCode('ENTP');
        $this->build();
    }

    public function test_tenant_should_not_be_empty()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('租户不存在');

        $this->factory->getValidOrgDomainDTO()->tenant(null);
        $this->build();
    }

    public function test_tenant_should_be_effective()
    {
        $tenant = $this->factory->getTenant();

        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage(sprintf('id为[%d]的租户不是有效租户！', $tenant->getId()));

        $tenantRepositoryStub = $this->createStub(TenantRepository::class);
        $tenantRepositoryStub->method('findById')->willReturn($tenant->setStatus(TenantStatus::Ineffective));
        app()->instance(TenantRepository::class, $tenantRepositoryStub);
        self::assertInstanceOf(TenantRepository::class, $tenantRepositoryStub);

        $this->build();
    }

    public function makeOrgBuilder(): OrgBuilder
    {
        return app(OrgBuilder::class);
    }

    public function build(): void
    {
        $this->makeOrgBuilder()
            ->orgDomainDTO($this->factory->getValidOrgDomainDTO())
            ->build();
    }
}

class TestDataFactory
{
    private Tenant $tenant;
    private OrgDomainDTO $validOrgDomainDTO;

    public static function make(): static
    {
        $factory = new static();
        $factory->makeTenant();
        $factory->makeOrgDomainDTO();
        return $factory;
    }

    public function makeTenant(): void
    {
        $this->tenant = (new Tenant())
            ->setStatus(TenantStatus::Effective);
    }

    public function makeOrgDomainDTO(): void
    {
        $this->validOrgDomainDTO = (new OrgDomainDTO())
            ->tenant($this->tenant)
            ->superiorId(1)
            ->orgTypeCode('test')
            ->name('测试部门');
    }

    public function getTenant(): Tenant
    {
        return $this->tenant;
    }

    public function getValidOrgDomainDTO(): OrgDomainDTO
    {
        return $this->validOrgDomainDTO;
    }
}
