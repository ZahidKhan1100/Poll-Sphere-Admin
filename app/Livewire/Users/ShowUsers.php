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
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;


class ShowUsers extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email')->icon('heroicon-m-envelope')
                    ->iconColor('primary')->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500),


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
        return view('livewire.users.show-users');
    }
}
