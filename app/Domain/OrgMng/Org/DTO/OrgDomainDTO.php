<?php

namespace App\Domain\OrgMng\Org\DTO;

class OrgDomainDTO
{
    private int $tenantId;
    private int $superiorId;
    private string $orgTypeCode;
    private string $name;

    /**
     * @return int
     */
    public function getTenantId(): int
    {
        return $this->tenantId;
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

    /**
     * @param int $tenantId
     * @return self
     */
    public function tenantId(int $tenantId): self
    {
        $this->tenantId = $tenantId;
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
