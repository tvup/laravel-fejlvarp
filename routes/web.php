<?php

Route::get('incidents', 'Tvup\LaravelFejlvarp\Http\Controllers\IncidentController@index')->name('incidents.index');
Route::get('incidents/{hash}', 'Tvup\LaravelFejlvarp\Http\Controllers\IncidentController@show')->name('incident.show');
Route::post('incidents/{hash}/delete', 'Tvup\LaravelFejlvarp\Http\Controllers\IncidentController@destroy')->name('incident.delete');
Route::post('incidents/delete', 'Tvup\LaravelFejlvarp\Http\Controllers\IncidentController@destroyAll')->name('incidents.delete');

Route::get('vendor/fejlvarp/app.css', 'Tvup\LaravelFejlvarp\Http\Controllers\AssetController@css')->name('fejlvarp.assets.css');
Route::get('vendor/fejlvarp/incidents.ico', 'Tvup\LaravelFejlvarp\Http\Controllers\AssetController@favicon')->name('fejlvarp.assets.favicon');
