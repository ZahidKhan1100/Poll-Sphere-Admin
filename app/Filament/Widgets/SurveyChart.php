<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use Filament\Widgets\ChartWidget;

class SurveyChart extends ChartWidget
{
    protected static ?string $heading = 'Surveys';

    protected static string $color = 'info';

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $draftCount = Survey::where('status', 'draft')->count();
        $publishedCount = Survey::where('status', 'published')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Survey Dataset',
                    'data' => [$draftCount, $publishedCount],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 205, 86)'
                    ],
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Draft', 'Published'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
