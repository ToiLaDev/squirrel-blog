<?php

use Illuminate\Support\Facades\Route;

Route::prefix('blog')->name('blog.')->group(function (){
    Route::put('categories/sort', 'CategoryController@sort')->name('categories.sort');
    Route::resource('posts', 'PostController');
    Route::resource('categories', 'CategoryController');
});
