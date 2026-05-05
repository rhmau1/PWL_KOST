<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Kamar;
use App\Models\Kos;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $kosIds = Kos::where('user_id', auth()->id())->pluck('id');

        $kamarTerisi = Kamar::whereIn('kos_id', $kosIds)
            ->where('is_available', false)
            ->count();

        $totalKamar = Kamar::whereIn('kos_id', $kosIds)->count();

        $estimasiPendapatan = Kamar::whereIn('kos_id', $kosIds)
            ->where('is_available', true)
            ->sum('harga');

        return [
            Stat::make('Kamar Terisi', "$kamarTerisi / $totalKamar"),
            Stat::make('Kamar Kosong', $totalKamar - $kamarTerisi),
        ];
    }
}
