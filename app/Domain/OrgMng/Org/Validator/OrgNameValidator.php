<?php

namespace App\Domain\OrgMng\Org\Validator;

use App\Domain\Common\Exceptions\BusinessException;

class OrgNameValidator
{
    public function verify(int $tenantId, int $superiorId, string $name)
    {
        $this->nameShouldNotEmpty($name);
        $this->nameShouldNotDuplicatedInSameSuperior($tenantId, $superiorId, $name);
    }

    private function nameShouldNotEmpty(string $name)
    {
        if (empty($name)) {
            throw new BusinessException("组织名不能为空");
        }
    }

    private function nameShouldNotDuplicatedInSameSuperior(int $tenantId, int $superiorId, string $name)
    {

    }
}
