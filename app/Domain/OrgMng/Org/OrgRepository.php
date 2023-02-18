<?php

namespace App\Domain\OrgMng\Org;

use App\Domain\OrgMng\Org\Org;

interface OrgRepository
{
    public function save(Org $org);
}
