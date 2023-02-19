<?php

use App\Http\Controllers\Restful\OrgMng\OrgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/organizations', [OrgController::class, 'addOrg']);
Route::put('/organizations/{id}/basic_info', [OrgController::class, 'updateOrgBasicInfo']);
