<?php

use Illuminate\Http\Request;
use Neewd\Newsletter\Http\Controllers\LayoutController;
use Neewd\Newsletter\Http\Controllers\TemplateController;
use Neewd\Newsletter\Http\Controllers\ImageController;
use Neewd\Newsletter\Http\Controllers\NewsletterController;
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

Route::prefix('/campaigns')->group(function () {
    Route::get('/', NewsletterController::class.'@indexCampaigns');
    Route::post('/', NewsletterController::class.'@createCampaign');
    Route::post('/send', NewsletterController::class.'@sendCampaignNow');
    Route::delete('/{campaignId}', NewsletterController::class.'@deleteCampaign');
});

Route::prefix('/list')->group(function () {
    Route::get('/{listId}', NewsletterController::class.'@getContactFromList');
    Route::put('/removeFromList', NewsletterController::class.'@removeContactFromList');
});

Route::prefix('/templates')->group(function () {
    Route::post('/', TemplateController::class.'@save');
    Route::get('/', TemplateController::class.'@index');
    Route::get('/{name}', TemplateController::class.'@get');
    Route::delete('/{name}', TemplateController::class.'@delete');
});

