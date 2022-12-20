<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

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

Route::prefix('v1')->group(function (Router $router) {
    $router->post('/user', [\App\Http\Controllers\Api\V1\AuthController::class, 'loginUser']);
});

JsonApiRoute::server('v1')->prefix('v1')->resources(function ($server) {
    $server->resource('resources', \App\Http\Controllers\Api\V1\ResourceController::class)
        ->readOnly()
        ->relationships(function ($relations) {
            $relations->hasMany('comments')->readOnly();
        })->middleware('auth.optional');

    $server->resource('resources', \App\Http\Controllers\Api\V1\ResourceController::class)->actions('-actions', function ($actions) {
        $actions->withId()->post('comment')->middleware('auth.optional');
    });

    $server->resource('bookings', \App\Http\Controllers\Api\V1\BookingController::class)
        ->readOnly()
        ->relationships(function ($relations) {
            $relations->hasOne('resource')->readOnly();
            $relations->hasOne('user')->readOnly();
            $relations->hasMany('comments')->readOnly();
        })->middleware('auth.optional');

    $server->resource('bookings', \App\Http\Controllers\Api\V1\BookingController::class)->actions('-actions', function ($actions) {
        $actions->withId()->post('comment')->middleware('auth.optional');
    });

    $server->resource('comments', \App\Http\Controllers\Api\V1\CommentController::class)
        ->readOnly()
        ->relationships(function ($relations) {
            $relations->hasMany('replies')->readOnly();
        })->middleware('auth.optional');

    $server->resource('comments', \App\Http\Controllers\Api\V1\CommentController::class)->actions('-actions', function ($actions) {
        $actions->withId()->post('reply')->middleware('auth.optional');
    });
});
