<?php

namespace App\Application\OrgMng\OrgService;

use App\Domain\OrgMng\Org\Org;

class OrgResponse
{
    private int $id;
    private int $tenant;
    private string $name;
    private string $orgType;
    private int $superior;

    public static function fromOrg(Org $org): static
    {
        $response = new static();
        $response->id = $org->getId();
        $response->tenant = $org->getTenant()->getId();
        $response->name = $org->getName();
        $response->orgType = $org->getOrgTypeCode();
        $response->superior = $org->getSuperiorId();
        return $response;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'tenant' => $this->tenant,
            'name' => $this->name,
            'orgType' => $this->orgType,
            'superior' => $this->superior,
        ];
    }
}
