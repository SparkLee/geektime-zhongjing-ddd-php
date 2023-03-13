<?php

namespace App\Http\Controllers\Restful\OrgMng;

use App\Application\OrgMng\OrgService\CreateOrgRequest;
use App\Application\OrgMng\OrgService\OrgService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Restful\OrgMng\Concerns\validatesOrgRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class OrgController extends Controller
{
    use validatesOrgRequests;

    private OrgService $orgService;

    public function __construct(OrgService $orgService)
    {
        $this->orgService = $orgService;
    }

    public function addOrg(Request $request): JsonResponse
    {
        try {
            $this->validateAddingOrg($request);
            $createOrgRequest = CreateOrgRequest::fromRequest($request);
            $orgResponse = $this->orgService->addOrg($createOrgRequest, 1);
            return response()->json($orgResponse->toArray());
        } catch (Throwable $e) {
            return response()->json(['err' => $e->getMessage()])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        }
    }

    public function updateOrgBasicInfo(): JsonResponse
    {
        return response()->json('success');
    }
}
