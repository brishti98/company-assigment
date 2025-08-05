<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix'=>'category'], function (Router $router) {
    $router->get('/', 'CategoryController@list');
    $router->get('/{id}', 'CategoryController@getCategoryDetail');
    $router->post('/', 'CategoryController@create');
    $router->put('/{id}', 'CategoryController@update');
    $router->delete('/{id}', 'CategoryController@delete');
    $router->get('', 'CategoryController@keywordDetails');
});


Route::group(['prefix'=>'company'], function (Router $router) {
    $router->get('/', 'CompanyController@list');
    $router->get('/{id}', 'CompanyController@getCompanyDetail');
    $router->post('/', 'CompanyController@create');
    $router->put('/{id}', 'CompanyController@update');
    $router->delete('/{id}', 'CompanyController@delete');
});
