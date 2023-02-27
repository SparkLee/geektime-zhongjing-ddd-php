<?php

namespace App\Domain\Common;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Illuminate\Support\Carbon;

#[MappedSuperclass]
#[HasLifecycleCallbacks]
abstract class AuditableEntity
{
    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    protected ?DateTimeImmutable $createdAt = null;

    #[Column(type: Types::INTEGER)]
    protected int $createdBy = 0;

    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    protected ?DateTimeImmutable $lastUpdatedAt = null;

    #[Column(type: Types::INTEGER)]
    protected int $lastUpdatedBy = 0;

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy
     * @return self
     */
    public function setCreatedBy(int $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getLastUpdatedAt(): ?DateTimeImmutable
    {
        return $this->lastUpdatedAt;
    }

    /**
     * @return int
     */
    public function getLastUpdatedBy(): int
    {
        return $this->lastUpdatedBy;
    }

    /**
     * @param int $lastUpdatedBy
     * @return self
     */
    public function setLastUpdatedBy(int $lastUpdatedBy): self
    {
        $this->lastUpdatedBy = $lastUpdatedBy;
        return $this;
    }

    #[PrePersist]
    #[PreUpdate]
    public function autoSetCreatedAtAndLastUpdatedAt(): self
    {
        $now = Carbon::now()->toDateTimeImmutable();

        if (is_null(($this->createdAt))) {
            $this->createdAt = $now;
        }
        $this->lastUpdatedAt = $now;

        return $this;
    }
}
