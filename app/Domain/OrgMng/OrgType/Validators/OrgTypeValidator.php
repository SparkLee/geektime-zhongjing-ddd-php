<?php

namespace App\Domain\OrgMng\OrgType\Validators;

use App\Domain\Common\Exceptions\BusinessException;
use App\Domain\OrgMng\OrgType\OrgTypeRepository;
use App\Domain\OrgMng\OrgType\OrgTypeStatus;
use App\Domain\TenantMng\Tenant;

class OrgTypeValidator
{
    private OrgTypeRepository $repository;

    public function __construct(OrgTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function verify(Tenant $tenant, string $orgTypeCode): void
    {
        $this->orgTypeShouldNotBeEmpty($orgTypeCode);
        $this->orgTypeShouldBeValid($tenant, $orgTypeCode);
        $this->shouldNotCreateEnterpriseAlone($orgTypeCode);
    }

    /**
     * @param string $orgTypeCode
     * @return void
     */
    public function orgTypeShouldNotBeEmpty(string $orgTypeCode): void
    {
        if (empty($orgTypeCode)) {
            throw new BusinessException("组织类别不能为空！");
        }
    }

    public function orgTypeShouldBeValid(Tenant $tenant, string $orgTypeCode): void
    {
        if (!$this->repository->existsByCodeAndStatus($tenant, $orgTypeCode, OrgTypeStatus::Effective)) {
            throw new BusinessException(sprintf("[%s]不是有效的组织类别代码！", $orgTypeCode));
        }
    }

    public function shouldNotCreateEnterpriseAlone(string $orgTypeCode): void
    {
        if ($orgTypeCode == 'ENTP') {
            throw new BusinessException('企业是在创建租户的时候创建好的，因此不能单独创建企业!');
        }
    }
}
