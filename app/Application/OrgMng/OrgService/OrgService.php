<?php

namespace App\Application\OrgMng\OrgService;

use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\Org;
use App\Domain\OrgMng\Org\OrgBuilder;
use App\Domain\OrgMng\Org\OrgRepository;
use App\Domain\TenantMng\TenantRepository;

class OrgService
{
    private TenantRepository $tenantRepository;
    private OrgRepository $orgRepository;
    private OrgBuilder $orgBuilder;

    public function __construct(TenantRepository $tenantRepository,
                                OrgRepository    $orgRepository,
                                OrgBuilder       $orgBuilder)
    {
        $this->orgRepository = $orgRepository;
        $this->orgBuilder = $orgBuilder;
        $this->tenantRepository = $tenantRepository;
    }

    public function addOrg(CreateOrgRequest $request, int $userId): OrgResponse
    {
        $org = $this->buildOrg($request);
        $org = $this->orgRepository->save($org);
        return OrgResponse::fromOrg($org);
    }

    public function buildOrg(CreateOrgRequest $request): Org
    {
        $tenant = $this->tenantRepository->findById($request->getTenant());
        $orgDomainDTO = (new OrgDomainDTO())
            ->tenant($tenant)
            ->superiorId($request->getSuperior())
            ->orgTypeCode($request->getOrgType())
            ->name($request->getName());

        return $this->orgBuilder
            ->orgDomainDTO($orgDomainDTO)
            ->build();
    }
}
