<?php

namespace App\Domain\OrgMng\Org\DTO;

class OrgDomainDTO
{
	private int $tenantId;
	private int $superiorId;
	private string $orgTypeCode;

	/**
	 * @return int
	 */
	public function getTenantId(): int
	{
		return $this->tenantId;
	}

	/**
	 * @return int
	 */
	public function getSuperiorId(): int
	{
		return $this->superiorId;
	}

	/**
	 * @return string
	 */
	public function getOrgTypeCode(): string
	{
		return $this->orgTypeCode;
	}

	/**
	 * @param int $tenantId
	 * @return self
	 */
	public function tenantId(int $tenantId): self
	{
		$this->tenantId = $tenantId;
		return $this;
	}

	/**
	 * @param int $superiorId
	 * @return self
	 */
	public function superiorId(int $superiorId): self
	{
		$this->superiorId = $superiorId;
		return $this;
	}

	/**
	 * @param string $orgTypeCode
	 * @return self
	 */
	public function orgTypeCode(string $orgTypeCode): self
	{
		$this->orgTypeCode = $orgTypeCode;
		return $this;
	}
}
