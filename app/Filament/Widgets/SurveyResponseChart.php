<?php

namespace App\Filament\Widgets;

use App\Models\Response;
use App\Models\Survey;
use Filament\Widgets\ChartWidget;

class SurveyResponseChart extends ChartWidget
{
    protected static ?string $heading = 'Responses';
    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {

        return [];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
