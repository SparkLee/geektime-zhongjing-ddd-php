<?php

namespace App\Persistence\OrgMng;

use App\Domain\Common\EffectiveStatus;
use App\Domain\OrgMng\Org\Org;
use App\Domain\OrgMng\Org\OrgRepository;
use App\Domain\TenantMng\Tenant;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class OrgRepositoryDoctrine extends EntityRepository implements OrgRepository
{
    public function findById(int $orgId): ?Org
    {
        return $this->find($orgId);
    }

    public function existsByIdAndStatus(Tenant|int $tenant, int $id, EffectiveStatus $status): bool
    {
        $org = $this->findOneBy(['tenant' => $tenant, 'id' => $id, 'status' => $status]);
        return !is_null($org);
    }

    public function save(Org $org): Org
    {
        EntityManager::persist($org);
        EntityManager::flush();
        return $org;
    }
}
