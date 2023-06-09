<?php

use App\Http\Controllers\GuestBookController;
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

Route::get('guest-book/search/{name}', [GuestBookController::class, 'getByName']); // route for autofill
Route::post('guestbook', [GuestBookController::class, 'store']);
Route::get('guest-sijelapp', [GuestBookController::class, 'getAllGuests_Sijelapp']);
Route::get('guest-book', [GuestBookController::class, 'index']);
