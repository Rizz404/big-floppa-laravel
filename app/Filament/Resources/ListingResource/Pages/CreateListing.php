<?php

namespace App\Filament\Resources\ListingResource\Pages;

use App\Filament\Resources\ListingResource;
use App\Models\Listing;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateListing extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = ListingResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Listing Details')
                ->description('Provide the main details of your listing.')
                ->schema([
                    Section::make()
                        ->schema([
                            Select::make('seller_id')
                                ->relationship('seller', 'name')
                                ->searchable()
                                // ->preload()
                                ->required(),
                            Select::make('breed_id')
                                ->relationship('breed', 'name')
                                ->searchable()
                                // ->preload()
                                ->required(),
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('Rp'),
                            DatePicker::make('birth_date')
                                ->required(),
                            Select::make('gender')
                                ->options(['male' => 'Male', 'female' => 'Female'])
                                ->required(),
                            TextInput::make('location')
                                ->required()
                                ->maxLength(255),
                            Toggle::make('is_vaccinated')->required(),
                            Toggle::make('is_dewormed')->required(),
                            RichEditor::make('description')->columnSpanFull(),
                        ])->columns(2),
                ]),
            Step::make('Photos')
                ->description('Add photos for your listing.')
                ->schema([
                    Repeater::make('photos')
                        ->relationship()
                        ->schema([
                            TextInput::make('path')
                                ->required()
                                ->label('Photo Path/URL'),
                            Toggle::make('is_primary')
                                ->label('Is Primary Photo?')
                                ->default(false),
                            TextInput::make('caption')
                                ->maxLength(255),
                        ])
                        ->defaultItems(1)
                        ->columns(2)
                        ->columnSpanFull(),
                ]),
        ];
    }
}
