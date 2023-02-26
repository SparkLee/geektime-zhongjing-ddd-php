<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\Common\AuditableEntity;
use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use Carbon\Carbon;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Org
{
    use AuditableEntity;

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
    private string $name = '';

    #[Column(type: Types::INTEGER)]
    private int $status = OrgStatus::EFFECTIVE;

    private function __construct()
    {
        $this->createdAt = Carbon::now()->toDateTimeImmutable();
        $this->lastUpdatedAt = Carbon::now()->toDateTimeImmutable();
    }

    public static function fromOrgDomainDTO(OrgDomainDTO $orgDomainDto): static
    {
        $org = new static;
        $org->tenantId = $orgDomainDto->getTenantId();
        $org->superiorId = $orgDomainDto->getSuperiorId();
        $org->orgTypeCode = $orgDomainDto->getOrgTypeCode();
        $org->name = $orgDomainDto->getName();
        return $org;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenantId(): int
    {
        return $this->tenantId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
