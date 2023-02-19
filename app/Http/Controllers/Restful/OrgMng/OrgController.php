<?php

namespace App\Http\Controllers\Restful\OrgMng;

use App\Application\OrgMng\OrgService\CreateOrgRequest;
use App\Application\OrgMng\OrgService\OrgService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrgController extends Controller
{
    private OrgService $orgService;

    public function __construct(OrgService $orgService)
    {
        $this->orgService = $orgService;
    }

    public function addOrg(Request $request): JsonResponse
    {
        $createOrgRequest = CreateOrgRequest::fromRequest($request);
        $orgResponse = $this->orgService->addOrg($createOrgRequest, 1);
        return response()->json($orgResponse->toArray());
    }

    public function updateOrgBasicInfo()
    {
        return response()->json('success');
    }
}
