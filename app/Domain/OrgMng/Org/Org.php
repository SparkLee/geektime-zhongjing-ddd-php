<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\OrgMng\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\OrgStatus;
use Carbon\Carbon;
use DateTimeImmutable;
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
    private int $superiorId = 0;

    #[Column(type: Types::STRING, length: 20)]
    private string $orgTypeCode = '';

    #[Column(type: Types::INTEGER)]
    private int $leaderId = 0;

    #[Column(type: Types::STRING, length: 100)]
    private $name = '';

    #[Column(type: Types::INTEGER)]
    private int $status = OrgStatus::EFFECTIVE;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[Column(type: Types::INTEGER)]
    private int $createdBy = 0;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $lastUpdatedAt;

    #[Column(type: Types::INTEGER)]
    private int $lastUpdatedBy = 0;

    private function __construct()
    {
        $this->createdAt = Carbon::now()->toDateTimeImmutable();
        $this->lastUpdatedAt = Carbon::now()->toDateTimeImmutable();
    }

    public static function fromOrgDomainDto(OrgDomainDTO $orgDomainDto): static
    {
        $org = new static;
        $org->tenantId = $orgDomainDto->getTenantId();
        $org->superiorId = $orgDomainDto->getSuperiorId();
        $org->orgTypeCode = $orgDomainDto->getOrgTypeCode();
        return $org;
    }
}
