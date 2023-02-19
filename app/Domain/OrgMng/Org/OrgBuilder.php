<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;

class OrgBuilder
{
    private OrgDomainDTO $orgDomainDTO;

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

    }
}
