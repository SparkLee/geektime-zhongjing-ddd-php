<?php

namespace App\Application\OrgMng\OrgService;

use Illuminate\Http\Request;

class CreateOrgRequest
{
    private int $id;
    private int $tenantId;
    private int $superiorId;
    private string $orgTypeCode;
    private int $leaderId;
    private string $name;
    private string $status;
    private string $createdAt;
    private int $createdBy;
    private string $lastUpdatedAt;
    private int $lastUpdatedBy;

    private function __construct()
    {

    }

    public static function fromRequest(Request $request): static
    {
        $dto = new static;
        $dto->tenantId = $request->integer('tenantId');
        $dto->superiorId = $request->integer('superiorId');
        $dto->orgTypeCode = $request->integer('orgTypeCode');
        return $dto;
    }

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
}