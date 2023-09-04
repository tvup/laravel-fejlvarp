<?php

Route::middleware(['admin','auth'])->get('incidents', 'Tvup\LaravelFejlvarp\Http\Controllers\IncidentController@index')->name('incidents.index');
Route::middleware(['admin','auth'])->get('incidents/{hash}', 'Tvup\LaravelFejlvarp\Http\Controllers\IncidentController@show')->name('incident.show');
Route::middleware(['admin','auth'])->post('incidents/{hash}/delete', 'Tvup\LaravelFejlvarp\Http\Controllers\IncidentController@destroy')->name('incident.delete');
Route::middleware(['admin','auth'])->post('incidents/delete', 'Tvup\LaravelFejlvarp\Http\Controllers\IncidentController@destroyAll')->name('incidents.delete');
