<?php

namespace App\Persistence\OrgMng;

use App\Domain\OrgMng\OrgType\OrgTypeRepository;
use App\Domain\OrgMng\OrgType\OrgTypeStatus;
use App\Domain\TenantMng\Tenant;
use Doctrine\ORM\EntityRepository;

class OrgTypeRepositoryDoctrine extends EntityRepository implements OrgTypeRepository
{

    public function existsByCodeAndStatus(Tenant|int $tenant, string $code, OrgTypeStatus|int $orgTypeStatus): bool
    {
        return $this->count(['tenant' => $tenant, 'code' => $code, 'status' => $orgTypeStatus]) > 0;
    }
}
