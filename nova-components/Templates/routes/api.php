<?php

use Illuminate\Http\Request;
use Neewd\Templates\Http\Controllers\LayoutController;
use Neewd\Templates\Http\Controllers\TemplateController;
use Neewd\Templates\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::prefix('/layouts')->group(function () {
    Route::get('/', LayoutController::class.'@index');
    Route::get('/{name}', LayoutController::class.'@get');
    Route::delete('/{name}', LayoutController::class.'@delete');
    Route::post('/', LayoutController::class.'@save');
    Route::post('/image', ImageController::class.'@save');
    Route::put('/delete-image',  ImageController::class.'@delete');
    Route::put('/delete-images', ImageController::class.'@deleteMultiple');
});

Route::post('/', TemplateController::class.'@save');
Route::post('/', TemplateController::class.'@index');
Route::get('/{name}', TemplateController::class.'@get');
Route::delete('/{name}', TemplateController::class.'@delete');
