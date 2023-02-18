<?php

namespace App\Application\OrgMng;

use Illuminate\Http\Request;

class OrgDto
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

    public static function fromRequest(Request $request): static
    {
        $dto = new static;
        $dto->tenantId = $request->integer('tenant_id');
        $dto->superiorId = $request->integer('superior_id');
        $dto->orgTypeCode = $request->integer('org_type_code');
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