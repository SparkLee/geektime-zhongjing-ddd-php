<?php

namespace App\Domain\OrgMng\Org\Validators;

use App\Domain\Common\Exceptions\BusinessException;
use App\Domain\TenantMng\TenantRepository;
use App\Domain\TenantMng\TenantStatus;

class CommonValidator
{
    private TenantRepository $tenantRepository;

    public function __construct(TenantRepository $tenantRepository)
    {
        $this->tenantRepository = $tenantRepository;
    }

    public function tenantShouldBeValid(int $tenantId): void
    {
        $this->tenantShouldNotBeEmpty($tenantId);
        $this->tenantShouldBeEffective($tenantId);
    }

    private function tenantShouldNotBeEmpty(int $tenantId): void
    {
        if (empty($tenantId)) {
            throw new BusinessException("租户不能为空");
        }
    }

    private function tenantShouldBeEffective(int $tenantId): void
    {
        if (!$this->tenantRepository->existsByIdAndStatus($tenantId, TenantStatus::Effective)) {
            throw new BusinessException(sprintf("id为[%d]的租户不是有效租户！", $tenantId));
        }
    }
}
