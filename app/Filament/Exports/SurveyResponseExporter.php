<?php

namespace App\Filament\Exports;

use App\Models\Response;
use App\Models\ResponseChoice;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SurveyResponseExporter extends Exporter
{
    protected static ?string $model = ResponseChoice::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('survey.title')
                ->label('Survey Title')
                ->getStateUsing(fn(Response $record) => $record->survey?->title ?? ''),

            ExportColumn::make('question.question')
                ->label('Question')
                ->getStateUsing(fn(Response $record) => $record->question?->question ?? ''),

            ExportColumn::make('question.type')
                ->label('Question Type')
                ->getStateUsing(fn(Response $record) => $record->question?->type->value ?? ''),

            ExportColumn::make('answer')
                ->label('Answer')
                ->getStateUsing(function (Response $record) {
                    if (in_array($record->question->type->value, ['checkbox', 'radio', 'select'])) {
                        return $record->choices->pluck('choice')->join(', ');
                    }
                    return $record->answer ?? '';
                }),

            ExportColumn::make('user.name')
                ->label('User Name')
                ->getStateUsing(fn(Response $record) => $record->user?->name ?? 'Anonymous'),
        ];
    }


    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your survey response export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
