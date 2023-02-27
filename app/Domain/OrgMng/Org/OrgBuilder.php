<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\Common\Validators\CommonValidator;
use App\Domain\OrgMng\Org\Validators\OrgNameValidator;

class OrgBuilder
{
    private OrgDomainDTO $orgDomainDTO;
    private OrgNameValidator $orgNameValidator;
    private CommonValidator $commonValidator;

    /**
     * @param OrgNameValidator $orgNameValidator
     */
    public function __construct(OrgNameValidator $orgNameValidator,
                                CommonValidator  $commonValidator)
    {
        $this->orgNameValidator = $orgNameValidator;
        $this->commonValidator = $commonValidator;
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
        $this->commonValidator->tenantShouldBeValid($dto->getTenantId());
        $this->orgNameValidator->verify($dto->getTenantId(), $dto->getSuperiorId(), $dto->getName());
    }
}
