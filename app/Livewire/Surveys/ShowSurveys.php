<?php

namespace App\Livewire\Surveys;

use App\Filament\Exports\SurveyExporter;
use App\Filament\Pages\Surveys;
use App\Models\Survey;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

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
                TextColumn::make('start_date'),
                TextColumn::make('end_date'),
                SelectColumn::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])->rules(['required']),
                TextColumn::make('user.name'),
            ])
            ->filters([
                // ...
            ])
            // ->headerActions([
            //     // Custom Create Button
            //     \Filament\Tables\Actions\Action::make('create')
            //         ->label('Create Survey')  // Label on the button
            //         ->icon('heroicon-o-plus') // Icon (optional)
            //         ->color('success')  // Button color (optional)
            //         ->url(route('filament.pages.create-survey')) // Assign the route URL to navigate to
            //         ->openUrlInNewTab(false),  // Set to true if you want to open in a new tab (optional)
            // ])
            ->headerActions([
                \Filament\Tables\Actions\Action::make('create')
                    ->label('Create')
                    ->icon('heroicon-o-plus')
                    ->form([
                        TextInput::make('title')
                            ->label('Title')
                            ->required(),
                        TextInput::make('description')
                            ->label('Description')
                            ->required(),
                        DateTimePicker::make('start_date'),
                        DateTimePicker::make('end_date'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])->searchable(),
                        Select::make('user_id')
                            ->label('Assigned User')
                            ->relationship('user', 'name', function ($query) {
                                return $query->where('id', '!=', Auth::id());
                            }) // Exclude the authenticated user
                            ->required(),
                        // Select::make('user_id')
                        //     ->label('Assigned User')
                        //     ->relationship('user', 'name')
                        //     ->required(),
                    ])
                    ->action(function (array $data): void {
                        Survey::create($data);
                    }),
                ExportAction::make()->exporter(SurveyExporter::class)->color('info')->icon('heroicon-o-arrow-down-tray'),
            ])
            ->actions([
                // ...
                EditAction::make()
                    ->form([
                        TextInput::make('title')
                            ->label('Title')
                            ->required(),
                        TextInput::make('description')
                            ->label('Description')
                            ->required(),
                        DateTimePicker::make('start_date'),
                        DateTimePicker::make('end_date'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])->searchable(),
                        Select::make('user_id')
                            ->label('Assigned User')
                            ->relationship('user', 'name', function ($query) {
                                return $query->where('id', '!=', Auth::id());
                            })
                            ->required(),
                    ]),
                DeleteAction::make(),

            ])
            ->bulkActions([
                // ...
                BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(fn(Survey $records) => $records->each->delete()),
                ExportBulkAction::make()
                    ->exporter(SurveyExporter::class)
            ]);
    }

    public function render()
    {
        return view('livewire.surveys.show-surveys');
    }
}
