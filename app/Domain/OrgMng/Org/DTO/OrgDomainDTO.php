<?php

namespace App\Domain\OrgMng\Org\DTO;

use App\Domain\TenantMng\Tenant;

class OrgDomainDTO
{
    private ?Tenant $tenant = null;
    private int $superiorId = 0;
    private string $orgTypeCode;
    private string $name;

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    /**
     * @return int
     */
    public function getSuperiorId(): int
    {
        return $this->superiorId;
    }

    /**
     * @return string
     */
    public function getOrgTypeCode(): string
    {
        return $this->orgTypeCode;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function tenant(?Tenant $tenant): self
    {
        $this->tenant = $tenant;
        return $this;
    }

    /**
     * @param int $superiorId
     * @return self
     */
    public function superiorId(int $superiorId): self
    {
        $this->superiorId = $superiorId;
        return $this;
    }

    /**
     * @param string $orgTypeCode
     * @return self
     */
    public function orgTypeCode(string $orgTypeCode): self
    {
        $this->orgTypeCode = $orgTypeCode;
        return $this;
    }

    /**
     * @param string $name
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
