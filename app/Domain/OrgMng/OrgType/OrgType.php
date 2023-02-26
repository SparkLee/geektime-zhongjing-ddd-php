<?php

namespace App\Domain\OrgMng\OrgType;

use App\Domain\Common\AuditableEntity;
use App\Domain\TenantMng\Tenant;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class OrgType
{
    use AuditableEntity;

    #[Id, Column(type: Types::STRING, length: 10)]
    private string $code;

    #[ManyToOne]
    private Tenant $tenant;

    #[Column(type: Types::STRING, length: 10)]
    private string $name;

    #[Column] private OrgTypeStatus $status = OrgTypeStatus::Effective;

    /**
     * @param string $code
     * @param Tenant $tenant
     * @param string $name
     * @param OrgTypeStatus $status
     */
    public function __construct(string $code, Tenant $tenant, string $name, OrgTypeStatus $status)
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

    /**
     * @param string $name
     * @return OrgType
     */
    public function setName(string $name): OrgType
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->CreatedAt;
    }

    /**
     * @return mixed
     */
    public function getLastUpdatedAt()
    {
        return $this->lastUpdatedAt;
    }

}
