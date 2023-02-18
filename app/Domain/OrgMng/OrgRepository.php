<?php

namespace App\Domain\OrgMng;

interface OrgRepository
{
    public function save(Org $org);
}