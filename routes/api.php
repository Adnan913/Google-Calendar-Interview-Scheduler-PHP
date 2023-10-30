<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendInvitation;
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

Route::post('/send-invitation', [SendInvitation::class, 'sendEmailInvitation']);
Route::get('/get-url', [SendInvitation::class, 'getUrl']);
Route::get('/get-token', [SendInvitation::class, 'getToken']);
Route::get('/is-expired', [SendInvitation::class, 'isExpired']);