<?php

namespace App\Filament\Resources\BreedScoreResource\Pages;

use App\Filament\Resources\BreedScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBreedScore extends EditRecord
{
    protected static string $resource = BreedScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
