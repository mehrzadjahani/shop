<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => '/user'], function ($router) {
    $router->post('/add', ['uses' => 'UserController@add']);
    $router->get('/list', ['uses' => 'UserController@list']);
    $router->get('/add_credit', ['uses' => 'BankTransactionController@addCredit','middleware'=>'auth:api']);
    $router->get('/user_credit', ['uses' => 'BankTransactionController@creditAmount','middleware'=>'auth:api']);
    $router->get('/pay_back', ['uses' => 'BankTransactionController@payBack','as'=>'user_pay_back']);
});
$router->group(['prefix' => '/product'], function ($router) {
    $router->post('/add', ['uses' => 'ProductController@add','as'=>'add_product']);
    $router->put('/edit/{id}', ['uses' => 'ProductController@edit','as'=>'edit_product']);
});
$router->group(['prefix' => '/order'], function ($router) {
    $router->post('/add', ['uses' => 'OrderController@add','as'=>'add_order','middleware'=>'auth:api']);
    $router->get('/pay_back', ['uses' => 'OrderController@payBack','as'=>'pay_back']);
});



$router->group([
    'prefix' => 'auth'
], function ($router) {

    $router->post('generate_jwt_token', ['uses'=>'AuthController@otpTokenRequest']);
    $router->post('otp_login', ['uses'=>'AuthController@otpLogin']);


    $router->post('login', ['uses'=>'AuthController@login']);
    $router->post('logout', ['uses'=>'AuthController@logout']);
    $router->post('refresh', ['uses'=>'AuthController@refresh']);
    $router->post('me', ['uses'=>'AuthController@me']);

});
