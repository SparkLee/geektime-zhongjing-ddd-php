<?php

namespace App\Domain\OrgMng\Org\Validators;

use App\Domain\Common\Exceptions\BusinessException;

class OrgNameValidator
{
    public function verify(int $tenantId, int $superiorId, string $name): void
    {
        $this->nameShouldNotBeEmpty($name);
        $this->nameShouldNotBeDuplicatedInTheSameSuperior($tenantId, $superiorId, $name);
    }

    private function nameShouldNotBeEmpty(string $name): void
    {
        if (empty($name)) {
            throw new BusinessException("组织名不能为空");
        }
    }

    private function nameShouldNotBeDuplicatedInTheSameSuperior(int $tenantId, int $superiorId, string $name): void
    {

    }
}
