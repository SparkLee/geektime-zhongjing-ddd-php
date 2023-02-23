<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\Validator\OrgNameValidator;

class OrgBuilder
{
    private OrgDomainDTO $orgDomainDTO;
    private OrgNameValidator $orgNameValidator;

    public function orgDomainDTO(OrgDomainDTO     $orgDomainDTO,
                                 OrgNameValidator $orgNameValidator): self
    {
        $this->orgDomainDTO = $orgDomainDTO;
        $this->orgNameValidator = $orgNameValidator;
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
