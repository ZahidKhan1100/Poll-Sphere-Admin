<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\CreateSurvey;


Route::get('/', function () {
    return view('welcome');
});



Route::get('admin/create-survey', CreateSurvey::class)
    ->name('filament.pages.create-survey');
