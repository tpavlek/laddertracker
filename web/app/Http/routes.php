<?php

Route::get('/', [ 'as' => 'home.index', 'uses' => 'HomeController@index' ]);
Route::get('/standings', function() { return redirect()->route('standings', \Depotwarehouse\BattleNetSC2Api\Region::America); })->name('home.standings');
Route::get('/standings/{region}', 'HomeController@standings')->name('standings');
Route::get('/about', [ 'as' => 'home.about', 'uses' => 'HomeController@about' ]);
Route::get('/history', [ 'as' => 'home.history', 'uses' => 'HomeController@history' ]);

Route::get('/login', [ 'as' => 'login', 'uses' => 'LoginController@login' ]);
Route::post('/login', [ 'as' => 'auth', 'uses' => 'LoginController@auth' ]);
Route::get('/logout', [ 'as' => 'logout', 'uses' => 'LoginController@logout' ]);

Route::get('/admin', [ 'as' => 'admin.index', 'uses' => 'AdminController@index' ]);
Route::get('/admin/dashboard', [ 'as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard' ]);

Route::get('/admin/user/create', [ 'as' => 'admin.user.create', 'uses' => 'UserController@create' ]);
Route::post('/admin/user', [ 'as' => 'admin.user.register', 'uses' => 'UserController@store' ]);
Route::get('/admin/user/list', 'UserController@listUsers')->name('admin.user.list');

Route::get('/admin/ladder/update', [ 'as' => 'admin.ladder.update', 'uses' => 'LadderController@update' ]);
Route::post('/admin/ladder/update', [ 'as' => 'admin.ladder.resync', 'uses' => 'LadderController@resync' ]);

Route::get('/admin/hero_points/add', [ 'as' => 'admin.hero_points.add', 'uses' => 'HeroPointController@add' ]);
Route::post('/admin/hero_points/add', [ 'as' => 'admin.hero_points.update', 'uses' => 'HeroPointController@update' ]);

Route::get('/admin/hero_points/award', [ 'as' => 'admin.hero_points.award', 'uses' => 'HeroPointController@showAwardForm' ]);
Route::post('/admin/hero_points/award', [ 'as' => 'admin.hero_points.update_all', 'uses' => 'HeroPointController@award' ]);

Route::get('/admin/hero_points/end_month', [ 'as' => 'admin.hero_points.end_month', 'uses' => 'HeroPointController@showEndMonthForm' ]);
Route::post('/admin/hero_points/end_month', [ 'as' => 'admin.hero_points.finalize_month', 'uses' => "HeroPointController@endMonth" ]);

Route::get('/admin/messages/create', 'Messages@showCreateForm')->name('admin.messages.create');
Route::post('/admin/messages/create', 'Messages@store')->name('admin.messages.store');

Route::get('admin/messages/expire', 'Messages@showExpireForm')->name('admin.messages.expire');
Route::post('/admin/messages/expire', 'Messages@expire')->name('admin.messages.finalize_expire');
