<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BreedScoreResource\Pages;
use App\Models\BreedScore;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

// Pastikan Resource untuk Breed dan Criterion sudah di-import
use App\Filament\Resources\BreedResource;
use App\Filament\Resources\CriterionResource;


class BreedScoreResource extends Resource
{
    protected static ?string $model = BreedScore::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('breed_id')
                    ->relationship('breed', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('criterion_id')
                    ->relationship('criterion', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('score')
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('breed.name')
                    ->description(fn(BreedScore $record): string => $record->breed->origin_country ?? '')
                    ->url(fn(BreedScore $record): string => BreedResource::getUrl('edit', ['record' => $record->breed]))
                    ->searchable(),
                Tables\Columns\TextColumn::make('criterion.name')
                    ->description(fn(BreedScore $record): string => $record->criterion->description ?? '')
                    ->url(fn(BreedScore $record): string => CriterionResource::getUrl('edit', ['record' => $record->criterion]))
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('breed')
                    ->relationship('breed', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('criterion')
                    ->relationship('criterion', 'name')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListBreedScores::route('/'),
            'create' => Pages\CreateBreedScore::route('/create'),
            'edit' => Pages\EditBreedScore::route('/{record}/edit'),
        ];
    }
}
