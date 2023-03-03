<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\Common\Validators\CommonValidator;
use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\Validators\OrgNameValidator;
use App\Domain\OrgMng\Org\Validators\SuperiorValidator;
use App\Domain\OrgMng\OrgType\Validators\OrgTypeValidator;

class OrgBuilder
{
    private OrgDomainDTO $orgDomainDTO;
    private CommonValidator $commonValidator;
    private OrgNameValidator $orgNameValidator;
    private OrgTypeValidator $orgTypeValidator;
    private SuperiorValidator $superiorValidator;

    public function __construct(CommonValidator   $commonValidator,
                                OrgNameValidator  $orgNameValidator,
                                OrgTypeValidator  $orgTypeValidator,
                                SuperiorValidator $superiorValidator)
    {
        $this->commonValidator = $commonValidator;
        $this->orgNameValidator = $orgNameValidator;
        $this->orgTypeValidator = $orgTypeValidator;
        $this->superiorValidator = $superiorValidator;
    }

    public function orgDomainDTO(OrgDomainDTO $orgDomainDTO): self
    {
        $this->orgDomainDTO = $orgDomainDTO;
        return $this;
    }

    public function build(): Org
    {
        $this->validate();
        return Org::fromOrgDomainDTO($this->orgDomainDTO);
    }

    private function validate(): void
    {
        $dto = $this->orgDomainDTO;
        $tenant = $dto->getTenant();

        $this->commonValidator->tenantShouldBeValid($tenant);
        $this->orgNameValidator->verify($tenant, $dto->getSuperiorId(), $dto->getName());
        $this->orgTypeValidator->verify($tenant, $dto->getOrgTypeCode());
        $this->superiorValidator->verify($tenant, $dto->getSuperiorId(), $dto->getOrgTypeCode());
    }
}
