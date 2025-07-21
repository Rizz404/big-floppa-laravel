<?php

namespace App\Filament\Resources\BreedScoreResource\Pages;

use App\Filament\Resources\BreedScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBreedScores extends ListRecords
{
    protected static string $resource = BreedScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
