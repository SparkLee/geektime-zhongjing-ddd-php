<?php

namespace App\Domain\OrgMng\Org\Validators;

use App\Domain\Common\EffectiveStatus;
use App\Domain\Common\Exceptions\BusinessException;
use App\Domain\OrgMng\Org\OrgRepository;
use App\Domain\TenantMng\Tenant;

class SuperiorValidator
{
    private OrgRepository $orgRepository;

    public function __construct(OrgRepository $orgRepository)
    {
        $this->orgRepository = $orgRepository;
    }

    public function verify(Tenant $tenant, int $superiorId, string $orgTypeCode): void
    {
        $this->superiorShouldBeEffective($tenant, $superiorId);
    }

    public function superiorShouldBeEffective(Tenant $tenant, int $superiorId): void
    {
        if (!$this->orgRepository->existsByIdAndStatus($tenant, $superiorId, EffectiveStatus::Effective)) {
            throw new  BusinessException("[{$superiorId}]不是有效的组织 id !");
        }
    }
}
