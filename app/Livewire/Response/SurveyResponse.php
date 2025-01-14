<?php

namespace App\Livewire\Response;

use App\Filament\Exports\SurveyResponseExporter;
use App\Models\Response;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\SelectColumn;


class SurveyResponse extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table->query(Response::with(['survey', 'question', 'choices', 'user']))->columns([
            TextColumn::make('survey.title')->label('Survey Title')->limit(20)
                ->tooltip(fn(Response $record): string => "{$record->survey?->title}"),
            TextColumn::make('question.question')->label('Question')->limit(20)
                ->tooltip(fn(Response $record): string => "{$record->question?->question}"),
            TextColumn::make('question.type')->label('Question Type'),
            TextColumn::make('answer')
                ->label('Answer')
                ->getStateUsing(function (Response $record) {
                    if (in_array($record->question->type->value, ['checkbox', 'radio', 'select'])) {
                        return $record->choices->pluck('choice')->join(', ');
                    }
                    return $record->answer;
                })
                ->limit(20)
                ->tooltip(function (Response $record): string {
                    if (in_array($record->question->type->value, ['checkbox', 'radio', 'select'])) {
                        return $record->choices->pluck('choice')->join(', ');
                    }
                    return $record->answer ?? '';
                }),
            TextColumn::make('user.name')
                ->label('User Name')
                ->badge()
                ->getStateUsing(function (Response $record) {
                    return $record->user?->name ?? 'Anonymous';
                }),
        ]) ->headerActions([
            ExportAction::make()->exporter(SurveyResponseExporter::class)->color('info')->icon('heroicon-o-arrow-down-tray'),
        ])
        
        ->bulkActions([
            ExportBulkAction::make()
                ->exporter(SurveyResponseExporter::class)
        ]);
    }

    public function render()
    {
        return view('livewire.response.survey-response');
    }
}
