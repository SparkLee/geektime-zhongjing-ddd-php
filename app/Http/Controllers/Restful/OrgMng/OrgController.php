<?php

namespace App\Http\Controllers\Restful\OrgMng;

use App\Application\OrgMng\OrgService\CreateOrgRequest;
use App\Application\OrgMng\OrgService\OrgService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class OrgController extends Controller
{
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

    /**
     * @throws ValidationException
     */
    public function validateAddingOrg(Request $request): void
    {
        $this->validate($request, [
            'tenant' => ['required', 'numeric', 'min:1'],
        ], [
            'tenant.required' => '租户不能为空',
            'tenant.numeric' => '租户必须是一个数字',
            'tenant.min' => '租户必须大于0',
        ]);
    }
}
