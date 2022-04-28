<?php

use Illuminate\Support\Facades\Route;

Route::post('/calculate/{resource}', 'FillButtonController@calculate')->name('upline.fill-button.calculate');
