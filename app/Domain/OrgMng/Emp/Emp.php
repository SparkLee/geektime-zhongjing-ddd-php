<?php

namespace App\Domain\OrgMng\Emp;

use App\Domain\Common\AuditableEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Emp extends AuditableEntity
{
    #[Id, GeneratedValue, Column(type: Types::INTEGER)]
    private int|null $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
