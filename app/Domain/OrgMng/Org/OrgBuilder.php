<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\Common\Validators\CommonValidator;
use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\Validators\OrgNameValidator;
use App\Domain\OrgMng\OrgType\Validators\OrgTypeValidator;

class OrgBuilder
{
    private OrgDomainDTO $orgDomainDTO;
    private CommonValidator $commonValidator;
    private OrgNameValidator $orgNameValidator;
    private OrgTypeValidator $orgTypeValidator;

    public function __construct(CommonValidator  $commonValidator,
                                OrgNameValidator $orgNameValidator,
                                OrgTypeValidator $orgTypeValidator)
    {
        $this->commonValidator = $commonValidator;
        $this->orgNameValidator = $orgNameValidator;
        $this->orgTypeValidator = $orgTypeValidator;
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
        $tenantId = $dto->getTenantId();

        $this->commonValidator->tenantShouldBeValid($tenantId);
        $this->orgNameValidator->verify($tenantId, $dto->getSuperiorId(), $dto->getName());
        $this->orgTypeValidator->verify($tenantId, $dto->getOrgTypeCode());
    }
}
