<?php

Route::get('/api/geoip', 'Tvup\LaravelFejlvarp\Http\Controllers\Api\IncidentController@geoip');
Route::get('/api/useragent', 'Tvup\LaravelFejlvarp\Http\Controllers\Api\IncidentController@useragent');
Route::post('/api/incidents', 'Tvup\LaravelFejlvarp\Http\Controllers\Api\IncidentController@store');
