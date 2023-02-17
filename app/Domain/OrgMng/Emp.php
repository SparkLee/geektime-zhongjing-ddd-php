<?php

namespace Unjuanable\Domain\OrgMng;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Emp
{
    #[Id, GeneratedValue, Column(type: Types::INTEGER)]
    private int|null $id = null;
}
