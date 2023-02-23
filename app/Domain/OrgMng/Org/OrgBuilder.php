<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\Validator\OrgNameValidator;

class OrgBuilder
{
    private OrgDomainDTO $orgDomainDTO;
    private OrgNameValidator $orgNameValidator;

    /**
     * @param OrgNameValidator $orgNameValidator
     */
    public function __construct(OrgNameValidator $orgNameValidator)
    {
        $this->orgNameValidator = $orgNameValidator;
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
        $this->orgNameValidator->verify($dto->getTenantId(), $dto->getSuperiorId(), $dto->getName());
    }
}
