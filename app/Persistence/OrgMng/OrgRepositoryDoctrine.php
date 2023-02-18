<?php

namespace App\Persistence\OrgMng;

use App\Domain\OrgMng\Org\Org;
use App\Domain\OrgMng\Org\OrgRepository;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class OrgRepositoryDoctrine extends EntityRepository implements OrgRepository
{
    public function save(Org $org): Org
    {
        EntityManager::persist($org);
        EntityManager::flush();
        return $org;
    }
}
