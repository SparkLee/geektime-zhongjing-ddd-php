<?php

namespace App\Domain\Common;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;

trait AuditableEntity
{
    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private DateTimeImmutable $createdAt;

    #[Column(type: Types::INTEGER, nullable: true)]
    private int $createdBy;

    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private DateTimeImmutable $lastUpdatedAt;

    #[Column(type: Types::INTEGER, nullable: true)]
    private int $lastUpdatedBy;
}
