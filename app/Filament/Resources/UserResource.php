<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Residents;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $activeNavigationIcon = 'heroicon-o-check-badge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Official Information')
                    ->schema([
                        Select::make('name')
                            ->label('Resident')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return Residents::query()
                                    ->where('firstname', 'like', '%' . $search . '%')
                                    ->orWhere('middlename', 'like', '%' . $search . '%')
                                    ->orWhere('lastname', 'like', '%' . $search . '%')
                                    ->get()
                                    ->mapWithKeys(function ($resident) {
                                        return [$resident->id => $resident->full_name];
                                    });
                            })
                            ->required()
                            ->reactive()
                            ->columnSpan(2)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $resident = Residents::find($state);
                                $official = \App\Models\Official::where('resident_id', $state)->first();
                                if ($resident) {
                                    $set('name', $resident->full_name);
                                    $set('email', $resident->resident_email);
                                    $set('pcontact', $resident->contact_number);
                                    $set('paddress', $resident->address);
                                    $set('resident_official_id', $resident->id);
                                }
                                if ($official) {
                                    $set('position', $official->position);
                                    $set('termStart', $official->term_start);
                                    $set('termEnd', $official->term_end);
                                    $set('status', $official->status);
                                }
                            })
                            ->afterStateHydrated(function ($state, callable $set){
                                $resident = Residents::find($state);
                                if ($resident) {
                                    $set('name', $resident->full_name);
                                    $set('email', $resident->resident_email);
                                    $set('pcontact', $resident->contact_number);
                                    $set('paddress', $resident->address);
                                    $set('resident_official_id', $resident->id);
                                }
                                $official = \App\Models\Official::where('resident_id', $state)->first();
                                if ($official) {
                                    $set('position', $official->position);
                                    $set('termStart', $official->term_start);
                                    $set('termEnd', $official->term_end);
                                    $set('status', $official->status);
                                }
                            }),
                            TextInput::make('resident_official_id')
                            ->label('Resident ID')
                            ->required()
                            ->readOnly()
                            ->afterStateHydrated(function ($state, callable $set){
                                $resident = Residents::find($state);
                                if ($resident) {
                                    $set('name', $resident->full_name);
                                    $set('email', $resident->resident_email);
                                    $set('pcontact', $resident->contact_number);
                                    $set('paddress', $resident->address);
                                    $set('resident_official_id', $resident->id);
                                }
                                $official = \App\Models\Official::where('resident_id', $state)->first();
                                if ($official) {
                                    $set('position', $official->position);
                                    $set('termStart', $official->term_start);
                                    $set('termEnd', $official->term_end);
                                    $set('status', $official->status);
                                }
                            }),
                    ])
                    ->columns(3),

                Section::make('Personal Information')
                    ->schema([
                        

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->readOnly(),

                        TextInput::make('pcontact')
                            ->label('Contact Number')
                            ->required()
                            ->readOnly(),

                        TextInput::make('paddress')
                            ->label('Address')
                            ->required()
                            ->readOnly(),
                    ])
                    ->columns(3),

                Section::make('Position Details')
                    ->schema([
                        TextInput::make('position')->required()->label('Position'),
                        TextInput::make('termStart')->required()->label('Term Start'),
                        TextInput::make('termEnd')->label('Term End'),
                       TextInput::make('status')
                        ->label('Status')
                        ->readOnly()
                        ->required(),
                    ])
                    ->columns(4),

                Section::make('Account Settings')
                    ->schema([
                        TextInput::make('username')
                            ->required(),

                        TextInput::make('password')
                            ->required()
                            ->password(),

                        Select::make('roles')
                        ->relationship('roles', 'name', fn ($query) => $query->whereNotIn('name', ['panel_user', 'super_admin']))
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('official.position')->label('Position'),
                TextColumn::make('roles.name')
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
