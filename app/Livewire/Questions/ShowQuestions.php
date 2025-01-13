<?php

namespace App\Livewire\Questions;

use App\Models\Question;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use App\QuestionType;
use Filament\Tables\Columns\ViewColumn;

class ShowQuestions extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {

        return $table
            ->query(Question::with('survey'))
            ->columns([
                TextColumn::make('survey.title')->label('Survey Title')->limit(20)
                    ->tooltip(fn(Question $record): string => "{$record->survey?->title}"),
                TextColumn::make('question'),
                // TextColumn::make('type')
                //     ->label('Type')
                //     ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                // TextColumn::make('type')
                //     ->label('Preview')
                //     ->html() // Enable rendering of HTML
                //     ->formatStateUsing(function (Question $record): string {
                //         // dd($record->type); // Check the value of `type` here
                //         // dd($record->type);
                //         return $record->type->value instanceof QuestionType
                //             ? $record->type->value->getHtmlPreview()
                //             : '<span>Unsupported type</span>';
                //     }),
                ViewColumn::make('type')
                    ->label('Type')
                    ->view('components.layouts.questions-type')->disabled(),
            ]);
    }

    public function render()
    {
        return view('livewire.questions.show-questions');
    }
}
