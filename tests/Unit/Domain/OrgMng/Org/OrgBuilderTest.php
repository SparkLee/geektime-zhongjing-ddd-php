<?php

namespace Tests\Unit\Domain\OrgMng\Org;

use App\Domain\Common\Exceptions\BusinessException;
use App\Domain\OrgMng\Org\DTO\OrgDomainDTO;
use App\Domain\OrgMng\Org\OrgBuilder;
use PHPUnit\Framework\TestCase;

class OrgBuilderTest extends TestCase
{
    public function test_org_name_should_not_empty()
    {
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('组织名不能为空');

        $orgDomainDTO = (new OrgDomainDTO())
            ->tenantId(1)
            ->superiorId(1)
            ->orgTypeCode('foo')
            ->name('');

        /** @var OrgBuilder $orgBuilder */
        $orgBuilder = app(OrgBuilder::class);

        return $orgBuilder
            ->orgDomainDTO($orgDomainDTO)
            ->build();
    }

}
