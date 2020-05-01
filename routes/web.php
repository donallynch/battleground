<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/* Landing page */
Route::get('/', 'IndexController@indexAction')
    ->name('index');
Route::get('/battles', 'BattlesController@indexAction')
    ->name('battles');
Route::get('/leaderboard', 'LeaderboardController@indexAction')
    ->name('leaderboard');
Route::get('/create-player', 'CreatePlayerController@indexAction')
    ->name('create-player');
Route::get('/submit-battle', 'SubmitBattleController@indexAction')
    ->name('submit-battle');
