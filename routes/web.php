<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Laravel\Lumen\Routing\Router;

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

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/daftar', ['uses' => 'AuthController@daftar']);
    $router->post('/masuk', ['uses' => 'AuthController@masuk']);
});

$router->group(['prefix' => 'pelanggan'], function () use ($router) {
    $router->get('/', ['uses' => 'PelangganController@getAll']);
    $router->get('/search/{nama}', ['uses' => 'PelangganController@getSearch']);
    $router->post('/history/{id}', ['uses' => 'TransactionController@getHistory']);
    $router->post('/{id}', ['uses' => 'PelangganController@getProfil']);
    //$router->post('/update/{id}', ['uses' => 'PelangganController@delete']);
    $router->post('/delete/{id}', ['uses' => 'PelangganController@delete']);
});

$router->group(['prefix' => 'film'], function () use ($router) {
    $router->get('/search/{title}', ['uses' => 'FilmController@getSearch']);
    $router->post('/jadwal/{id}', ['uses' => 'JadwalController@getByFilm']);
    $router->put('/update/{id}', ['uses' => 'FilmController@updateFilm']);
    $router->post('/delete/{id}', ['uses' => 'FilmController@deleteFilm']);
    $router->post('/add', ['uses' => 'FilmController@addFilm']);
    $router->post('/{id}', ['uses' => 'FilmController@getDetailFilm']);
    $router->get('/', ['uses' => 'FilmController@getAll']);
});

$router->group(['prefix' => 'kelas'], function () use ($router) {
    $router->get('/', ['uses' => 'KelasController@getAll']);
    $router->post('/add', ['uses' => 'KelasController@add']);
});

$router->group(['prefix' => 'studio'], function () use ($router) {
    $router->get('/', ['uses' => 'StudioController@getAll']);
    $router->post('/add', ['uses' => 'StudioController@add']);
});

$router->group(['prefix' => 'jadwal'], function () use ($router) {
    $router->get('/', ['uses' => 'JadwalController@getAll']);
    $router->get('/search/{title}', ['uses' => 'JadwalController@getSearch']);
    $router->post('/add', ['uses' => 'JadwalController@add']);
    $router->post('/{id}', ['uses' => 'JadwalController@getDetail']);
    //$router->put('/update/{id}', ['uses' => 'JadwalController@delete']);
    $router->post('/delete/{id}',    ['uses' => 'JadwalController@delete']);
});

$router->group(['prefix' => 'transaction'], function () use ($router) {
    $router->get('/', ['uses' => 'TransactionController@getAll']);
    $router->post('/add', ['uses' => 'TransactionController@createTransaction']);
});