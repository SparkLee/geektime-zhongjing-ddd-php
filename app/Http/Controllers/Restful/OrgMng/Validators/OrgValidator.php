<?php

namespace App\Http\Controllers\Restful\OrgMng\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait OrgValidator
{
    /**
     * @throws ValidationException
     */
    protected function validateAddingOrg(Request $request): void
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
