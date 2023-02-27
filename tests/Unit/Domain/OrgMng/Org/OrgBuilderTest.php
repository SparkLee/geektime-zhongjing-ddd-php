<?php

namespace Tests\Unit\Domain\OrgMng\Org;

use App\Domain\Common\Exceptions\BusinessException;
use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\OrgBuilder;
use App\Domain\OrgMng\OrgType\OrgTypeRepository;
use App\Domain\TenantMng\TenantRepository;
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
     *
     * 注意：$this->createStub() 的返回值要先赋值给一个局部变量，比如 $stub, 然后再使用 $stub->method()->willReturn()，否则返回的类型将不是预期的类型，会报类似这样的错误：
     * "Argument #1 ($tenantRepository) must be of type App\Domain\TenantMng\TenantRepository, PHPUnit\Framework\MockObject\Builder\InvocationMocker given"
     * @see https://github.com/sebastianbergmann/phpunit/issues/3706#issuecomment-513094256
     */
    public function setUpRepositoryStubs(): void
    {
        $tenantRepositoryStub = $this->createStub(TenantRepository::class);
        $tenantRepositoryStub->method('existsByIdAndStatus')->willReturn(true);
        app()->instance(TenantRepository::class, $tenantRepositoryStub);

        $orgTypeRepositoryStub = $this->createStub(OrgTypeRepository::class);
        $orgTypeRepositoryStub->method('existsByCodeAndStatus')->willReturn(true);
        app()->instance(OrgTypeRepository::class, $orgTypeRepositoryStub);
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

        $tenantRepositoryStub = $this->createStub(TenantRepository::class);
        $tenantRepositoryStub->method('existsByIdAndStatus')->willReturn(false);
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
            ->orgDomainDTO($this->validOrgDomainDTO)
            ->build();
    }
}
