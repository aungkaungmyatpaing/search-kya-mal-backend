<?php

use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\FieldController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\NewController;
use App\Http\Controllers\API\TypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('regions',[LocationController::class,'getRegions']);
Route::get('townships',[LocationController::class,'getTownships']);
Route::get('fields',[FieldController::class,'getFields']);
Route::get('field/details',[FieldController::class,'getFieldDetails']);
Route::get('types', [TypeController::class,'getTypes']);
Route::get('weekdays', [TypeController::class,'getWeekdays']);
Route::get('weekends', [TypeController::class,'getWeekends']);
Route::get('categories', [NewController::class,'getCategories']);
Route::get('articles', [NewController::class,'getArticles']);
Route::get('contact', [ContactController::class,'getContact']);
