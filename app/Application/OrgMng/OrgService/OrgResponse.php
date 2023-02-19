<?php

namespace App\Application\OrgMng\OrgService;

use App\Domain\OrgMng\Org\Org;

class OrgResponse
{
    private int $id;
    private int $tenantId;

    public static function fromOrg(Org $org): static
    {
        $response = new static();
        $response->id = $org->getId();
        $response->tenantId = $org->getTenantId();
        return $response;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'tenantId' => $this->tenantId,
        ];
    }
}
