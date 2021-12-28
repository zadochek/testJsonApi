<?php

use App\Http\Controllers\Document\DocumentController;
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

//Document
Route::resource('/v1/document', DocumentController::class);
Route::post('/v1/document/{id}/publish', [DocumentController::class, 'publish']);
