<?php

use App\Http\Controllers\Api\{CategoryController, CompanyController};
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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

Route::middleware('api.authenticate')->group(function () {
    Route::group(['prefix'=>'category'], function (Router $router) {
        $router->get('/', [CategoryController::class, 'list']);
        $router->get('/{id}', [CategoryController::class, 'getCategoryDetail']);
        $router->post('/', [CategoryController::class, 'create']);
        $router->put('/{id}', [CategoryController::class, 'update']);
        $router->delete('/{id}', [CategoryController::class, 'delete']);
        // $router->get('', [CategoryController::class, 'keywordDetails']);
    });


    Route::group(['prefix'=>'company'], function (Router $router) {
        $router->get('/', [CompanyController::class, 'list']);
        $router->get('/{id}', [CompanyController::class, 'getCompanyDetail']);
        $router->post('/', [CompanyController::class, 'create']);
        $router->put('/{id}', [CompanyController::class, 'update']);
        $router->delete('/{id}', [CompanyController::class, 'delete']);
    });

});
