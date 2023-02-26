<?php

namespace App\Domain\OrgMng\OrgType;

use App\Domain\TenantMng\Tenant;

interface OrgTypeRepository
{
    public function existsByCodeAndStatus(Tenant|int $tenant, string $code, OrgTypeStatus $orgTypeStatus): bool;
}
