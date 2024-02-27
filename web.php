<?php

Route::get('/', 'HomeController@index')->name('index');
Route::get('/load-data', 'HomeController@loadData')->name('load_data');