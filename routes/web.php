<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->group(['prefix' => 'api'], function () use ($router) {

    //user routes

    $router->post('users', ['uses' => 'UserController@create'] );
    $router->get('users', ['uses' => 'UserController@index'] );
    $router->put('users/{user_id}', ['uses' => 'UserController@update'] );



    //user companies

    $router->post('companies', ['uses' => 'Company@create'] );
    $router->get('companies', ['uses' => 'Company@index'] );
    $router->put('companies/{company_id}', ['uses' => 'Company@update'] );



    //contract routes
    $router->post('branches/{branch_id}/contracts', ['uses' => 'ContractController@create']);

  });