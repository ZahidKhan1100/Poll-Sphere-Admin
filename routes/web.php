<?php

use App\Livewire\Survey\CreateSurvey;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('survey/create-survey', CreateSurvey::class);
