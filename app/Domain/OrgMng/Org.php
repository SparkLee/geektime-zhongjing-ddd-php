<?php

namespace Unjuanable\Domain\OrgMng;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Org
{
    #[Id, GeneratedValue, Column(type: Types::INTEGER)]
    private int|null $id = null;

    #[Column(type: Types::INTEGER)]
    private int $tenantId;

    #[Column(type: Types::INTEGER)]
    private int $superiorId;

    #[Column(type: Types::STRING, length: 20)]
    private string $orgTypeCode;

    #[Column(type: Types::INTEGER)]
    private int $leaderId;

    #[Column(type: Types::STRING, length: 100)]
    private $name;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTime $createdAt;

    #[Column(type: Types::INTEGER)]
    private int $createdBy;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTime $lastUpdatedAt;

    #[Column(type: Types::INTEGER)]
    private int $lastUpdatedBy;
}
