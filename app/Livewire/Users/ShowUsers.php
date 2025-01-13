<?php

namespace App\Livewire\Users;

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
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;


class ShowUsers extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            // ->query(User::query()->where('id','!=' Auth::id()))
            ->query(User::query()->when(Auth::check(), fn($query) => $query->where('id', '!=', Auth::id())))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email')->icon('heroicon-m-envelope')
                    ->iconColor('primary')->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500),


            ])
            ->headerActions([
                \Filament\Tables\Actions\Action::make('create')
                    ->label('Create')
                    ->icon('heroicon-o-plus')
                    ->form([
                        TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->required()->email()->unique('users', 'email'),
                        TextInput::make('password')
                            ->label('Password')
                            ->password() // Mask the input
                            ->required() // Make it required
                            ->minLength(8) // Minimum password length
                            ->maxLength(64) // Maximum password length
                            ->rules(['confirmed','required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'])
                            ->helperText('Password must be at least 8 characters long and include a mix of uppercase, lowercase, numbers, and special characters.')
                            ->dehydrated(fn($state) => !empty($state)), // Save only if password is provided
                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->requiredWith('password')
                    ])
                    ->action(function (array $data): void {
                        User::create($data);
                    }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
                EditAction::make()
                    ->form([
                        TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->required()->email()->unique('users', 'email'),
                    ]),
                DeleteAction::make(),

            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.users.show-users');
    }
}
