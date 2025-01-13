<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Questions extends Page
{
    protected static ?string $navigationGroup = 'Surveys';

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static string $view = 'filament.pages.questions';
}
