<?php

namespace App\Domain\TenantMng;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Tenant
{
    #[Id, GeneratedValue, Column(type: Types::INTEGER)]
    private int|null $id = null;

    #[Column(type: Types::INTEGER)]
    private int $status = TenantStatus::Effective->value;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $status
     * @return Tenant
     */
    public function setStatus(int $status): Tenant
    {
        $this->status = $status;
        return $this;
    }
}
