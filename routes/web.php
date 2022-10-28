<?php

use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/{whatever}', function () {
//   return 'This is API only service.';
// })->where('whatever', '.*?');

Route::get('/setup', [SetupController::class, 'setup'])->name('user.setup');