<?php

namespace App\Filament\Widgets;

use App\Models\Criterion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CriterionTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Costs", Criterion::query()->where("type", "cost")->count()),
            Stat::make("Benefits", Criterion::query()->where("type", "benefit")->count()),
        ];
    }
}
