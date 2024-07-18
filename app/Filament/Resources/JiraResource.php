<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JiraResource\Pages;
use App\Filament\Resources\JiraResource\RelationManagers;
use App\Models\Jira;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
class JiraResource extends Resource
{
    protected static ?string $model = Jira::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'server_based' => 'Server Based',
                        'cloud_based' => 'Cloud Based',
                    ]),
                Forms\Components\TextInput::make('name')
                    ->placeholder("eSpace")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('domain')
                    ->placeholder("https://jira.espace.ws")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_name')
                    ->placeholder("khaled.mostafa")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('domain'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJiras::route('/'),
            'create' => Pages\CreateJira::route('/create'),
            'view' => Pages\ViewJira::route('/{record}'),
            'edit' => Pages\EditJira::route('/{record}/edit'),
        ];
    }
}
