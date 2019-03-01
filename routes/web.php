<?php

Route::get('/', 'GalleryController@showImages')->name('showImages');
Route::post('upload-image', 'GalleryController@uploadImage')->name('uploadImage');
Route::post('delete-image', 'GalleryController@deleteImage')->name('deleteImage');
Route::post('sort-image', 'GalleryController@sortImage')->name('sortImage');
