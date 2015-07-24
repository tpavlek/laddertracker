<?php

get('/', [ 'as' => 'home.index', 'uses' => 'HomeController@index' ]);
get('/standings', [ 'as' => 'home.standings', 'uses' => 'HomeController@standings' ]);
get('/about', [ 'as' => 'home.about', 'uses' => 'HomeController@about' ]);
