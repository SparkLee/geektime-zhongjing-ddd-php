<?php

namespace App\Domain\TenantMng;

interface TenantRepository
{
    public function existsByIdAndStatus(int $tenantId, TenantStatus $tenantStatus): bool;
}
