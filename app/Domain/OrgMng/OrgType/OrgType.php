<?php

namespace App\Domain\OrgMng\OrgType;

use App\Domain\TenantMng\Tenant;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class OrgType
{
    #[Id, Column(type: Types::STRING, length: 10)]
    private string $code;

    #[ManyToOne]
    private Tenant $tenant;

    #[Column(type: Types::STRING, length: 10)]
    private string $name;

    #[Column(type: Types::INTEGER)]
    private int $status = OrgTypeStatus::Effective->value;

    /**
     * @param string $code
     * @param Tenant $tenant
     * @param string $name
     * @param int $status
     */
    public function __construct(string $code, Tenant $tenant, string $name, int $status)
    {
        $this->code = $code;
        $this->tenant = $tenant;
        $this->name = $name;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return Tenant
     */
    public function getTenant(): Tenant
    {
        return $this->tenant;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
