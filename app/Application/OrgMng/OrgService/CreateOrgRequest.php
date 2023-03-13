<?php

namespace App\Application\OrgMng\OrgService;

class CreateOrgRequest
{
    private int $id;
    private int $tenant;
    private int $superior;
    private string $orgType;
    private int $leaderId;
    private string $name;
    private string $status;
    private string $createdAt;
    private int $createdBy;
    private string $lastUpdatedAt;
    private int $lastUpdatedBy;

    /**
     * @return int
     */
    public function getTenant(): int
    {
        return $this->tenant;
    }

    /**
     * @return int
     */
    public function getSuperior(): int
    {
        return $this->superior;
    }

    /**
     * @return string
     */
    public function getOrgType(): string
    {
        return $this->orgType;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
