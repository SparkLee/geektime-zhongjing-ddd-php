<?php

namespace App\Application\OrgMng\OrgService;

use App\Domain\OrgMng\Org\Org;

class OrgResponse
{
    private int $id;
    private int $tenantId;
    private string $name;
    private string $orgTypeCode;

    public static function fromOrg(Org $org): static
    {
        $response = new static();
        $response->id = $org->getId();
        $response->tenantId = $org->getTenantId();
        $response->name = $org->getName();
        $response->orgTypeCode = $org->getOrgTypeCode();
        return $response;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'tenantId' => $this->tenantId,
            'name' => $this->name,
            'orgTypeCode' => $this->orgTypeCode,
        ];
    }
}
