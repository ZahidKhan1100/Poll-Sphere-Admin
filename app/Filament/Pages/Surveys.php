<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Surveys extends Page


{
    protected static ?string $navigationGroup = 'Surveys';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.surveys';
}
