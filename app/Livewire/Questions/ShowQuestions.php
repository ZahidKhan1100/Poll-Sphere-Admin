<?php

namespace App\Livewire\Questions;

use App\Models\Question;
use App\Models\Choice;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use App\QuestionType;
use Closure;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ViewColumn;

class ShowQuestions extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {

        return $table
            ->query(Question::with(['survey', 'choices']))

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
            ])
            ->headerActions([
                \Filament\Tables\Actions\Action::make('create')
                    ->label('Create')
                    ->icon('heroicon-o-plus')
                    ->form([
                        // TextInput::make('question')
                        //     ->label('Question')
                        //     ->required(),
                        // Radio::make('status')
                        //     ->options(QuestionType::class)->columns(6),
                        // Select::make('survey_id')->label('Assigned Survey')->relationship('survey', 'title')
                        Tabs::make('Create Question')
                            ->tabs([
                                // Tab 1: Question Details
                                Tabs\Tab::make('Details')
                                    ->schema([
                                        TextInput::make('question')
                                            ->label('Question')
                                            ->required(),
                                        Radio::make('type')
                                            ->options(QuestionType::class)->columns(6)->required(),
                                        Select::make('survey_id')
                                            ->label('Assigned Survey')
                                            ->relationship('survey', 'title')
                                            ->required(),
                                    ]),

                                // Tab 2: Choices (conditionally visible)
                                Tabs\Tab::make('Choices')
                                    ->schema([
                                        Repeater::make('choices') // Assumes 'choices' is a field in your data
                                            ->label('Choices')
                                            ->schema([
                                                TextInput::make('choice')
                                                    ->label('Choice')
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->addActionLabel('Add Choice'),
                                    ])
                                    ->visible(fn($get) => in_array($get('type'), ['checkbox', 'select','radio'])),

                            ]),
                    ])
                    ->action(function (array $data): void {
                        $question = Question::create([
                            'question' => $data['question'],
                            'type' => $data['type'],
                            'survey_id' => $data['survey_id'],
                        ]);

                        // Save choices if present
                        if (!empty($data['choices'])) {
                            foreach ($data['choices'] as $choice) {
                                $question->choices()->create(['choice' => $choice['choice']]);
                            }
                        }
                    }),
            ])
            ->actions([
                // ...
                EditAction::make()
                    ->form([
                        TextInput::make('question')
                            ->label('Question')
                            ->required(),
                        Radio::make('type')
                            ->options(QuestionType::class)
                            ->columns(6)
                            ->required(),
                        Select::make('survey_id')
                            ->label('Assigned Survey')
                            ->relationship('survey', 'title')
                            ->required(),
                        Repeater::make('choices') // Assumes 'choices' is a field in your data
                            ->relationship('choices')
                            ->label('Choices')
                            ->schema([
                                TextInput::make('choice')
                                    ->label('Choice')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add Choice')
                            ->visible(fn($get) => in_array($get('type'), ['checkbox', 'select','radio']))
                            ->rule(fn($get) => in_array($get('type'), ['checkbox', 'select','radio']) ? 'required' : null),
                    ]),


                // EditAction::make()
                //     ->form([
                //         Tabs::make('Edit Question')
                //             ->tabs([
                //                 Tabs\Tab::make('Details')
                //                     ->schema([
                //                         TextInput::make('question')
                //                             ->label('Question')
                //                             ->required(),
                //                         Radio::make('type')
                //                             ->options(QuestionType::class)
                //                             ->columns(6)
                //                             ->required(),

                //                         Select::make('survey_id')
                //                             ->label('Assigned Survey')
                //                             ->relationship('survey', 'title')
                //                             ->required(),
                //                     ]),
                //                 // Tab 2: Choices (conditionally visible)
                //                 Tabs\Tab::make('Choices')
                //                     ->schema([
                //                         Repeater::make('choices') // Assumes 'choices' is a field in your data
                //                             ->relationship('choices')
                //                             ->label('Choices')
                //                             ->schema([
                //                                 TextInput::make('choice')
                //                                     ->label('Choice')
                //                                     ->required(),
                //                             ])
                //                             ->columns(2)
                //                             ->addActionLabel('Add Choice'),
                //                     ])
                //                     ->visible(fn($get) => in_array($get('type'), ['checkbox', 'select'])),
                //             ]),
                //         ]),

                DeleteAction::make(),

            ]);
    }

    public function render()
    {
        return view('livewire.questions.show-questions');
    }
}
