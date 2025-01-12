<?php

namespace App\Livewire\Surveys;

use App\Models\Survey;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class ShowSurveys extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Survey::query())
            ->columns([
                TextColumn::make('title')->limit(20)
                    ->tooltip(fn(Survey $record): string => "{$record->title}"),
                TextColumn::make('description')->html()->limit(30)
                    ->tooltip(fn(Survey $record): string => "{$record->description}"),
                TextColumn::make('user.name'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
                EditAction::make(),
                DeleteAction::make(),

            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.surveys.show-surveys');
    }
}
