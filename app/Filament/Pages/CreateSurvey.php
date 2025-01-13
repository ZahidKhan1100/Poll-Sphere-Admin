<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CreateSurvey extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.pages.create-survey';
}
