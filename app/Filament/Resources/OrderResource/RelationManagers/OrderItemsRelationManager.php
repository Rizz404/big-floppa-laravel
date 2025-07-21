<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// * Cuma dipake ke relasi hasMany (One-to-Many) dan belongsToMany (Many-to-Many)
// * Kalo cuma belongsTo atau hasOne gak perlu
class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('listing.title')
                    ->label('Item')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('listing.seller.name')
                    ->label('Seller')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price_at_purchase')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(), // Dihilangkan agar read-only
            ])
            ->actions([
                // Tables\Actions\EditAction::make(), // Dihilangkan agar read-only
                // Tables\Actions\DeleteAction::make(), // Dihilangkan agar read-only
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
