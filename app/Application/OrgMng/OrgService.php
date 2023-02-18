<?php

namespace App\Application\OrgMng;

use App\Domain\OrgMng\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org;
use App\Domain\OrgMng\OrgRepository;

class OrgService
{
    private OrgRepository $orgRepository;

    public function __construct(OrgRepository $orgRepository)
    {
        $this->orgRepository = $orgRepository;
    }

    public function addOrg(OrgDto $orgDto, int $userId)
    {
        $orgDomainDTO = new OrgDomainDTO(
            $orgDto->getTenantId(),
            $orgDto->getSuperiorId(),
            $orgDto->getOrgTypeCode()
        );
        return $this->orgRepository->save(Org::fromOrgDomainDto($orgDomainDTO));
    }
}