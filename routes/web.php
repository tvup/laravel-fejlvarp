<?php

Route::get('incidents', 'Tvup\LaravelFejlVarp\Http\Controllers\IncidentController@index')->name('incidents.index');
Route::get('incidents/{hash}', 'Tvup\LaravelFejlVarp\Http\Controllers\IncidentController@show')->name('incident.show');
Route::post('incidents/{hash}/delete', 'Tvup\LaravelFejlVarp\Http\Controllers\IncidentController@destroy')->name('incident.delete');
Route::post('incidents/delete', 'Tvup\LaravelFejlVarp\Http\Controllers\IncidentController@destroyAll')->name('incidents.delete');







