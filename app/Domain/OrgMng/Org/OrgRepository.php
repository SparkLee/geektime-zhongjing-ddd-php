<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\Common\EffectiveStatus;
use App\Domain\TenantMng\Tenant;

interface OrgRepository
{
    public function findById(int $orgId): ?Org;

    public function existsByIdAndStatus(Tenant|int $tenant, int $id, EffectiveStatus $status): bool;

    public function save(Org $org): Org;
}
