<?php

namespace App\Application\OrgMng\OrgService;

use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\Org;
use App\Domain\OrgMng\Org\OrgBuilder;
use App\Domain\OrgMng\Org\OrgRepository;

class OrgService
{
    private OrgRepository $orgRepository;
    private OrgBuilder $orgBuilder;

    public function __construct(OrgRepository $orgRepository, OrgBuilder $orgBuilder)
    {
        $this->orgRepository = $orgRepository;
        $this->orgBuilder = $orgBuilder;
    }

    public function addOrg(CreateOrgRequest $request, int $userId): OrgResponse
    {
        $org = $this->buildOrg($request);
        $org = $this->orgRepository->save($org);
        return OrgResponse::fromOrg($org);
    }

    public function buildOrg(CreateOrgRequest $request): Org
    {
        $orgDomainDTO = (new OrgDomainDTO())
            ->tenantId($request->getTenant())
            ->superiorId($request->getSuperior())
            ->orgTypeCode($request->getOrgType())
            ->name($request->getName());

        return $this->orgBuilder
            ->orgDomainDTO($orgDomainDTO)
            ->build();
    }
}
