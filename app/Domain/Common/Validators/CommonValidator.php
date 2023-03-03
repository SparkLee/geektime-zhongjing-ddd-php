<?php

namespace App\Domain\Common\Validators;

use App\Domain\Common\Exceptions\BusinessException;
use App\Domain\TenantMng\Tenant;

class CommonValidator
{
    public function tenantShouldBeValid(?Tenant $tenant): void
    {
        $this->tenantShouldNotBeEmpty($tenant);
        $this->tenantShouldBeEffective($tenant);
    }

    private function tenantShouldNotBeEmpty(?Tenant $tenant): void
    {
        if (is_null($tenant)) {
            throw new BusinessException("租户不能为空");
        }
    }

    private function tenantShouldBeEffective(Tenant $tenant): void
    {
        if ($tenant->isIneffective()) {
            throw new BusinessException(sprintf("id为[%d]的租户不是有效租户！", $tenant->getId()));
        }
    }
}
