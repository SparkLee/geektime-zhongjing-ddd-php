<?php

namespace App\Http\Controllers\Restful\OrgMng;

use App\Application\OrgMng\OrgService\CreateOrgRequest;
use App\Application\OrgMng\OrgService\OrgService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestMapper;
use App\Http\Controllers\Restful\OrgMng\Concerns\ValidatesOrgRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class OrgController extends Controller
{
    use ValidatesOrgRequests;

    private OrgService $orgService;

    public function __construct(OrgService $orgService)
    {
        $this->orgService = $orgService;
    }

    public function addOrg(Request $request): JsonResponse
    {
        try {
            $this->validateAddingOrg($request);
            $createOrgRequest = RequestMapper::map($request, CreateOrgRequest::class);
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
