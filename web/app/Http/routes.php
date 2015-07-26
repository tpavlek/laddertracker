<?php

get('/', [ 'as' => 'home.index', 'uses' => 'HomeController@index' ]);
get('/standings', [ 'as' => 'home.standings', 'uses' => 'HomeController@standings' ]);
get('/about', [ 'as' => 'home.about', 'uses' => 'HomeController@about' ]);
get('/history', [ 'as' => 'home.history', 'uses' => 'HomeController@history' ]);

get('/login', [ 'as' => 'login', 'uses' => 'LoginController@login' ]);
post('/login', [ 'as' => 'auth', 'uses' => 'LoginController@auth' ]);
get('/logout', [ 'as' => 'logout', 'uses' => 'LoginController@logout' ]);

get('/admin', [ 'as' => 'admin.index', 'uses' => 'AdminController@index' ]);
get('/admin/dashboard', [ 'as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard' ]);

get('/admin/user/create', [ 'as' => 'admin.user.create', 'uses' => 'UserController@create' ]);
post('/admin/user', [ 'as' => 'admin.user.register', 'uses' => 'UserController@store' ]);

get('/admin/ladder/update', [ 'as' => 'admin.ladder.update', 'uses' => 'LadderController@update' ]);
post('/admin/ladder/update', [ 'as' => 'admin.ladder.resync', 'uses' => 'LadderController@resync' ]);

get('/admin/hero_points/add', [ 'as' => 'admin.hero_points.add', 'uses' => 'HeroPointController@add' ]);
post('/admin/hero_points/add', [ 'as' => 'admin.hero_points.update', 'uses' => 'HeroPointController@update' ]);

get('/admin/hero_points/award', [ 'as' => 'admin.hero_points.award', 'uses' => 'HeroPointController@showAwardForm' ]);
post('/admin/hero_points/award', [ 'as' => 'admin.hero_points.update_all', 'uses' => 'HeroPointController@award' ]);

get('/admin/hero_points/end_month', [ 'as' => 'admin.hero_points.end_month', 'uses' => 'HeroPointController@showEndMonthForm' ]);
post('/admin/hero_points/end_month', [ 'as' => 'admin.hero_points.finalize_month', 'uses' => "HeroPointController@endMonth" ]);
