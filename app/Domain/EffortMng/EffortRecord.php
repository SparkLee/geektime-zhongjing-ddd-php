<?php

namespace App\Domain\EffortMng;

use App\Domain\Common\AuditableEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class EffortRecord extends AuditableEntity
{
    #[Id, GeneratedValue, Column(type: Types::INTEGER)]
    private int|null $id = null;
}
