<?php

namespace App\Filament\Widgets;

use App\Models\VisitLog;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class VisitTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Kunjungan Harian';
    protected static ?int $sort = 2; // urutan tampil di dashboard

    protected function getData(): array
    {
        // Ambil data jumlah kunjungan per tanggal (total semua slug)
        $data = VisitLog::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $data->pluck('date')->toArray();
        $totals = $data->pluck('total')->toArray();

        $datasets = [
            [
                'label' => 'Total Kunjungan',
                'data' => $totals,
            ],
        ];

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
