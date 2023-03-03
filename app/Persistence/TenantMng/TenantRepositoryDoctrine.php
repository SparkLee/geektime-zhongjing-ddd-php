<?php

namespace App\Persistence\TenantMng;

use App\Domain\TenantMng\Tenant;
use App\Domain\TenantMng\TenantRepository;
use App\Domain\TenantMng\TenantStatus;
use Doctrine\ORM\EntityRepository;

class TenantRepositoryDoctrine extends EntityRepository implements TenantRepository
{
    public function findById(int $tenantId): ?Tenant
    {
        return $this->find($tenantId);
    }

    public function existsByIdAndStatus(int $tenantId, TenantStatus $tenantStatus): bool
    {
        return $this->count(['id' => $tenantId, 'status' => $tenantStatus->value]) > 0;
    }
}
