<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AxiousController;
// use App\Http\Controllers\Api\RestLikeController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    '/projectform' => 'Api\RestProjectController',
    '/profileform' => 'Api\RestProfileController',
    '/message' => 'Api\RestDirectMessageController',
    '/applyuser' => 'Api\RestAppliedUserController',
    '/like' => 'Api\RestLikeController',
    '/p_message' => 'Api\RestPublicMessageController'
]);


