<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'IndexController@indexAction')
    ->name('index');

Route::get('/login', 'Auth\LoginController@indexAction')
    ->name('login');

Route::post('/login', 'Auth\LoginController@postAction')
    ->name('login-post');

Route::get('/battles', 'BattlesController@indexAction')
    ->name('battles');

Route::get('/leaderboard', 'LeaderboardController@indexAction')
    ->name('leaderboard');

Route::get('/create-player', 'CreatePlayerController@indexAction')
    ->name('create-player');

Route::post('/create-player', 'CreatePlayerController@postAction')
    ->name('create-player-post');

Route::get('/submit-battle', 'SubmitBattleController@indexAction')
    ->name('submit-battle');

Route::post('/submit-battle', 'SubmitBattleController@postAction')
    ->name('submit-battle-post');
