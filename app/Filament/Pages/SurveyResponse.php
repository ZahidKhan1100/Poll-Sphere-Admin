<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SurveyResponse extends Page
{
    protected static ?string $navigationGroup = 'Surveys';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    protected static string $view = 'filament.pages.survey-response';
}
