<?php

namespace App\Application\OrgMng\OrgService;

use Illuminate\Http\Request;

class CreateOrgRequest
{
    private int $id;
    private int $tenant;
    private int $superiorId;
    private string $orgType;
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
        $dto->tenant = $request->integer('tenant');
        $dto->superiorId = $request->integer('superior');
        $dto->orgType = $request->str('orgType');
        $dto->name = $request->str('name');
        return $dto;
    }

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
    public function getSuperiorId(): int
    {
        return $this->superiorId;
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
