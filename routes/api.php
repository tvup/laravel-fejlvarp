<?php

Route::get('/api/geoip', 'Tvup\LaravelFejlVarp\Http\Controllers\Api\IncidentController@geoip');
Route::get('/api/useragent', 'Tvup\LaravelFejlVarp\Http\Controllers\Api\IncidentController@useragent');
Route::post('/api/incidents', 'Tvup\LaravelFejlVarp\Http\Controllers\Api\IncidentController@store');
