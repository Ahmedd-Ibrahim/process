<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\AuthController;
use App\Http\Controllers\Api\V1\Admin\ReportController;
use App\Http\Controllers\Api\V1\Admin\PaymentController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\SubCategoryController;
use App\Http\Controllers\Api\V1\Admin\TransactionController;
use App\Http\Controllers\Api\V1\User\TransactionController as CustomerTransactionController;

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

Route::group([
    'prefix' => 'v1',
], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::middleware(['admin'])->group(function () {
            Route::apiResource('category', CategoryController::class);
            Route::apiResource('sub-category', SubCategoryController::class);
            Route::apiResource('transaction', TransactionController::class)->only('store', 'show', 'index');
            Route::apiResource('payment', PaymentController::class);
            Route::post('monthly-report', [ReportController::class, 'monthlyReport']);
            Route::post('report', [ReportController::class, 'report']);
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('{user}/transaction/{transaction}', [CustomerTransactionController::class, 'show']);
        });
    });
});
