<?php

namespace App\Domain\TenantMng;

interface TenantRepository
{
    public function findById(int $tenantId): ?Tenant;

    public function existsByIdAndStatus(int $tenantId, TenantStatus $tenantStatus): bool;
}
