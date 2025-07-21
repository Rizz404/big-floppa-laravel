<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // * Gak bisa create order di admin, soalnya logika konto
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Update Status')
                    ->schema([
                        Select::make('status')
                            ->label('Order Status')
                            ->options([
                                'pending_payment' => 'Pending Payment',
                                'paid' => 'Paid',
                                'shipping' => 'Shipping',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                                'refunded' => 'Refunded',
                            ])
                            ->required(),
                        Select::make('payment.status')
                            ->label('Payment Status')
                            ->options([
                                'pending' => 'Pending',
                                'settlement' => 'Settlement',
                                'expire' => 'Expire',
                                'cancel' => 'Cancel',
                                'deny' => 'Deny',
                            ])
                            ->relationship('payment', 'status')
                            ->hidden(fn($record) => $record->payment === null),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable(),
                TextColumn::make('buyer.name')
                    ->label('Buyer')
                    ->description(fn(Order $record): string => $record->buyer->email)
                    ->url(fn(Order $record): string => UserResource::getUrl('edit', ['record' => $record->buyer]))
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Order Status')
                    ->colors([
                        'warning' => 'pending_payment',
                        'success' => 'paid',
                        'info' => 'shipping',
                        'primary' => 'completed',
                        'danger' => fn($state) => in_array($state, ['cancelled', 'refunded']),
                    ])
                    ->badge()
                    ->searchable(),
                TextColumn::make('payment.status')
                    ->label('Payment Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'settlement',
                        'danger' => fn($state) => in_array($state, ['expire', 'cancel', 'deny']),
                    ])
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Order Status')
                    ->options([
                        'pending_payment' => 'Pending Payment',
                        'paid' => 'Paid',
                        'shipping' => 'Shipping',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'refunded' => 'Refunded',
                    ]),
                SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->relationship('payment', 'status')
                    ->options([
                        'pending' => 'Pending',
                        'settlement' => 'Settlement',
                        'expire' => 'Expire',
                        'cancel' => 'Cancel',
                        'deny' => 'Deny',
                    ]),
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
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
