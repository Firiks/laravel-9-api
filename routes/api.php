<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\InvoiceController;
use App\Http\Controllers\API\V1\CustomerController;

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


// V1
Route::group(['prefix' => 'v1', 'as' => 'v1.', 'namespace' => 'App\Http\Controllers\API\V1'], function() {
  Route::post('/register', [UserController::class, 'register']);
  Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore'])->name('invoices.bulkstore');
  });
});