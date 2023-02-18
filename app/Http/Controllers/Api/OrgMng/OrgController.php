<?php

namespace App\Http\Controllers\Api\OrgMng;

use App\Application\OrgMng\OrgDto;
use App\Application\OrgMng\OrgService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgController extends Controller
{
    private OrgService $orgService;

    public function __construct(OrgService $orgService)
    {
        $this->orgService = $orgService;
    }

    public function addOrg(Request $request)
    {
        $orgDto = OrgDto::fromRequest($request);

        $this->orgService->addOrg($orgDto, 1);

        return response()->json('success');
    }
}