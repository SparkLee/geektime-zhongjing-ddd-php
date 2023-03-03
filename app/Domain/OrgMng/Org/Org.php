<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\Common\AuditableEntity;
use App\Domain\Common\EffectiveStatus;
use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\TenantMng\Tenant;
use Carbon\Carbon;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Org extends AuditableEntity
{
    #[Id, GeneratedValue, Column(type: Types::INTEGER)]
    private int|null $id = null;

    #[ManyToOne]
    private Tenant $tenant;

    #[Column(type: Types::INTEGER)]
    private int $superiorId = 0;

    #[Column(type: Types::STRING, length: 20)]
    private string $orgTypeCode = '';

    #[Column(type: Types::INTEGER)]
    private int $leaderId = 0;

    #[Column(type: Types::STRING, length: 100)]
    private string $name = '';

    #[Column(type: Types::INTEGER, enumType: EffectiveStatus::class)]
    private EffectiveStatus $status = EffectiveStatus::Effective;

    private function __construct()
    {
        $this->createdAt = Carbon::now()->toDateTimeImmutable();
        $this->lastUpdatedAt = Carbon::now()->toDateTimeImmutable();
    }

    public static function fromOrgDomainDTO(OrgDomainDTO $orgDomainDto): static
    {
        $org = new static;
        $org->tenant = $orgDomainDto->getTenant();
        $org->superiorId = $orgDomainDto->getSuperiorId();
        $org->orgTypeCode = $orgDomainDto->getOrgTypeCode();
        $org->name = $orgDomainDto->getName();
        return $org;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenant(): Tenant
    {
        return $this->tenant;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOrgTypeCode(): string
    {
        return $this->orgTypeCode;
    }

    public function getSuperiorId(): int
    {
        return $this->superiorId;
    }
}
