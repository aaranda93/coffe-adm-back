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



  $router->group(['middleware' => 'client'], function () use ($router) {
    
    //register Route
    
    

  });




  $router->group(['middleware' => 'auth:api'], function () use ($router) {


    //user logged 
    
    $router->get('me', ['uses' => 'Auth\AuthController@user'] );

    

    //user routes
    $router->get('users/{user_id}', ['uses' => 'V1\UserController@show'] );
    $router->post('users', ['uses' => 'V1\UserController@create'] );
    $router->get('users', ['uses' => 'V1\UserController@index'] );
    $router->put('users/{user_id}', ['uses' => 'V1\UserController@update'] );



    //companies routes

    $router->post('companies', ['uses' => 'V1\ContractController@create'] );
    $router->get('companies', ['uses' => 'V1\ContractController@index'] );
    $router->put('companies/{company_id}', ['uses' => 'V1\ContractController@update'] );



    //contract routes

    $router->post('branches/{branch_id}/contracts', ['uses' => 'V1\ContractController@create']);

  });
    
    








  });