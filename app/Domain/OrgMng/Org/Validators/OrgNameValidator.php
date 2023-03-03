<?php

namespace App\Domain\OrgMng\Org\Validators;

use App\Domain\Common\Exceptions\BusinessException;
use App\Domain\TenantMng\Tenant;

class OrgNameValidator
{
    public function verify(Tenant $tenant, int $superiorId, string $name): void
    {
        $this->nameShouldNotBeEmpty($name);
        $this->nameShouldNotBeDuplicatedInTheSameSuperior($tenant, $superiorId, $name);
    }

    private function nameShouldNotBeEmpty(string $name): void
    {
        if (empty($name)) {
            throw new BusinessException("组织名不能为空");
        }
    }

    private function nameShouldNotBeDuplicatedInTheSameSuperior(Tenant $tenant, int $superiorId, string $name): void
    {

    }
}
