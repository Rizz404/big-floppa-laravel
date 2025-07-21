<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SessionFinalRankingResource\Pages;
use App\Filament\Resources\SessionFinalRankingResource\RelationManagers;
use App\Models\SessionFinalRanking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SessionFinalRankingResource extends Resource
{
    protected static ?string $model = SessionFinalRanking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('evaluation_session_id')
                    ->required()
                    ->maxLength(26),
                Forms\Components\TextInput::make('breed_id')
                    ->required()
                    ->maxLength(26),
                Forms\Components\TextInput::make('final_score')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('rank')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('evaluation_session_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('breed_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('final_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rank')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSessionFinalRankings::route('/'),
            'create' => Pages\CreateSessionFinalRanking::route('/create'),
            'edit' => Pages\EditSessionFinalRanking::route('/{record}/edit'),
        ];
    }
}
