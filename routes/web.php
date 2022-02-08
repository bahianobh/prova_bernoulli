<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('campeonato')->group(function () {
    Route::get('/', 'CampeonatoController@index')->name('campeonato');
    Route::post('/cadastrar_confronto', 'CampeonatoController@create')->name('campeonato.cadastro');
});
