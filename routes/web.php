<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', 'Auth\\LoginController@login');
    $router->post('/register', 'Auth\\RegisterController@register');

    $router->group(['prefix' => 'category'], function () use ($router) {
        $router->get('/', 'CategoriesController@index');
        $router->get('/htmltree', 'CategoriesController@getCategoryHtmlTree');
        $router->get('/{id}', 'CategoriesController@show');
    });

    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        $router->get('/me', 'Auth\\LoginController@userDetails');
        $router->get('/logout', 'Auth\\LoginController@logout');
        $router->get('/check-login', 'Auth\\LoginController@checkLogin');

        $router->group(['prefix' => 'category'], function () use ($router) {
            $router->post('/', 'CategoriesController@store');
            $router->put('/{id}', 'CategoriesController@update');
            $router->delete('/{id}', 'CategoriesController@destroy');
        });
    });
});
