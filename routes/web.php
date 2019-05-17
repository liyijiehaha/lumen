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
//$router->post('/reg','Test\RegController@reg');
//$router->get('/login','Test\RegController@login');
//$router->post('/logindo','Test\RegController@logindo');
//注册
$router->post('/regdo','Test\RegController@regdo');
//登录
$router->post('/loginadddo','Test\RegController@loginadddo');
//$router->post('/userinfo','Test\RegController@userinfo');
//个人中心
$router->post('/userinfo', [
    'as'=>'profile',
    'uses'=>'Test\RegController@userinfo',
    'middleware' => 'checklogin',
]);
//商品列表
$router->post('/goods','Test\RegController@goods');
//商品详情页
$router->get('/goodsdetail','Test\RegController@goodsdetail');
//$router->post('/goodsdetail', [
  //  'as'=>'profile',
   // 'uses'=>'Test\RegController@userinfo',
   // 'middleware' => 'checklogin',
//]);
//购物车
$router->post('/addcart','Test\RegController@addcart');
//购物车列表
$router->post('/cartinfo','Test\RegController@cartinfo');
$router->post('/addorder','Test\RegController@addorder');
$router->post('/orderdetail','Test\RegController@orderdetail');












