<?php

Route::middleware('guest')->get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->get('/links', 'Link\ShortenedLinkController@index')->name('links');

Route::middleware('auth')->post('/shortened-link/create', 'Link\ShortenedLinkController@create')->name('shortened_link.create');
Route::middleware('auth')->delete('/shortened-link/delete/{link_id}', 'Link\ShortenedLinkController@delete')->name('shortened_link.delete');
Route::middleware('auth')->get('/shortened-link/success/{link_id}', 'Link\ShortenedLinkController@success')->name('shortened_link.success');

Route::get('/_{token}', 'Link\FollowShortenedLinkController@followLink')->name('shortened_link.follow');
