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
//$router->post('/code','Test\TestController@code');
//$router->post('/fcode','Test\TestController@fcode');
//$router->post('/testsign','Test\TestController@testsign');

//kaoshi
$router->post('/reg','Test\RegController@reg');
$router->get('/login','Test\RegController@login');
$router->post('/logindo','Test\RegController@logindo');
$router->post('/regdo','Test\RegController@regdo');
$router->post('/loginadddo','Test\RegController@loginadddo');
//$router->post('/userinfo','Test\RegController@userinfo');
$router->post('/userinfo', [
    'as'=>'profile',
    'uses'=>'Test\RegController@userinfo',
    'middleware' => 'checklogin',
]);