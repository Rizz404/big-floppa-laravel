<?php

namespace App\Filament\Resources\SessionFinalRankingResource\Pages;

use App\Filament\Resources\SessionFinalRankingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSessionFinalRanking extends EditRecord
{
    protected static string $resource = SessionFinalRankingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
