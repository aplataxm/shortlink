<?php

Route::middleware('guest')->get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->get('/links', 'Link\ShortenedLinkController@index')->name('links');

Route::middleware('auth')->prefix('/shortened-link')->group(
    function () {
        Route::post('/create', 'Link\ShortenedLinkController@create')->name('shortened_link.create');
        Route::delete('/delete/{link_id}', 'Link\ShortenedLinkController@delete')->name('shortened_link.delete');
    }
);

Route::get('/{token}', 'Link\FollowShortenedLinkController@followLink')->name('shortened_link.follow');
