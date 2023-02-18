<?php

namespace App\Domain\OrgMng\DTO;

class OrgDomainDTO
{
    private int $tenantId;
    private int $superiorId;
    private string $orgTypeCode;

    /**
     * @param int $tenantId
     * @param int $superiorId
     * @param string $orgTypeCode
     */
    public function __construct(int $tenantId, int $superiorId, string $orgTypeCode) {
    	$this->tenantId = $tenantId;
    	$this->superiorId = $superiorId;
    	$this->orgTypeCode = $orgTypeCode;
    }

	/**
	 * @return int
	 */
	public function getTenantId(): int {
		return $this->tenantId;
	}
	
	/**
	 * @return int
	 */
	public function getSuperiorId(): int {
		return $this->superiorId;
	}
	
	/**
	 * @return string
	 */
	public function getOrgTypeCode(): string {
		return $this->orgTypeCode;
	}
}