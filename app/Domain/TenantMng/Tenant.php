<?php

namespace App\Domain\TenantMng;

use App\Domain\Common\AuditableEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Tenant extends AuditableEntity
{
    #[Id, GeneratedValue, Column(type: Types::INTEGER)]
    private int|null $id = null;

    #[Column(type: Types::INTEGER, enumType: TenantStatus::class)]
    private TenantStatus $status = TenantStatus::Effective;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setStatus(TenantStatus $status): Tenant
    {
        $this->status = $status;
        return $this;
    }

    public function isEffective(): bool
    {
        return $this->status === TenantStatus::Effective;
    }

    public function isIneffective(): bool
    {
        return $this->status === TenantStatus::Ineffective;
    }
}
