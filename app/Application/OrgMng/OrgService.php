<?php

namespace App\Application\OrgMng;

use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\Org;
use App\Domain\OrgMng\Org\OrgRepository;

class OrgService
{
    private OrgRepository $orgRepository;

    public function __construct(OrgRepository $orgRepository)
    {
        $this->orgRepository = $orgRepository;
    }

    public function addOrg(OrgDto $orgDto, int $userId)
    {
        $orgDomainDTO = (new OrgDomainDTO())
            ->tenantId($orgDto->getTenantId())
            ->superiorId($orgDto->getSuperiorId())
            ->orgTypeCode($orgDto->getOrgTypeCode());

        return $this->orgRepository->save(Org::fromOrgDomainDto($orgDomainDTO));
    }
}
