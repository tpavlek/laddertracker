<?php

get('/', [ 'as' => 'home.index', 'uses' => 'HomeController@index' ]);
get('/standings', [ 'as' => 'home.standings', 'uses' => 'HomeController@standings' ]);
get('/about', [ 'as' => 'home.about', 'uses' => 'HomeController@about' ]);

get('/login', [ 'as' => 'login', 'uses' => 'LoginController@login' ]);
post('/login', [ 'as' => 'auth', 'uses' => 'LoginController@auth' ]);

get('/admin/dashboard', [ 'as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard' ]);
