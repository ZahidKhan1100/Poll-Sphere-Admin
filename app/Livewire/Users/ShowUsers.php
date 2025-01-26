<?php

namespace App\Livewire\Users;

use App\Models\Question;
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
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

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
                TextColumn::make('roles.name') // Display assigned roles
                    ->label('Roles')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('roles.permissions.name') // Get permissions through the roles relationship
                    ->label('Permissions')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        // Get all permissions for the user by joining with roles and permissions
                        return $record->getAllPermissions()->pluck('name')->implode(', ');
                    }),
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
                            ->minLength(2) // Minimum password length
                            ->maxLength(64) // Maximum password length
                            // ->rules(['confirmed', 'required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'])
                            ->helperText('Password must be at least 8 characters long and include a mix of uppercase, lowercase, numbers, and special characters.')
                            ->dehydrated(fn($state) => !empty($state)), // Save only if password is provided
                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->requiredWith('password'),
                        Select::make('roles')
                            ->label('Roles')
                            ->multiple() // Allow selecting multiple roles
                            ->options(Role::all()->pluck('name', 'id')->toArray()) // Provide role options
                            ->required()
                            ->reactive() // Enable reactivity
                            ->dehydrated(true) // Ensure value is included in form data
                            ->placeholder('Select roles'),

                    ])->visible(fn () => Auth::user()?->hasRole('admin'))
                    ->action(function (array $data): void {
                        $roleIds = $data['roles'] ?? [];
                        $roles = Role::whereIn('id', $roleIds)->pluck('name')->toArray();

                        // Create the user
                        $user = User::create([
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'password' => $data['password'],
                        ]);

                        // Assign roles to the user
                        $user->assignRole($roles);

                        // Optional: Debug
                        // dd($user, $roles);
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
                            ->required()->email(),
                        Select::make('roles')
                            ->label('Roles')
                            ->multiple() // Allow selecting multiple roles
                            ->relationship('roles', 'name') // Uses the roles relationship
                            ->options(Role::all()->pluck('name', 'id')->toArray()) // Fetch roles
                            ->required(),
                    ])->visible(fn () => Auth::user()?->hasRole('admin')),
                DeleteAction::make()->visible(fn () => Auth::user()?->hasRole('admin')),

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
