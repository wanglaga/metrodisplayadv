<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;

class UserVisitLeaderboard extends ChartWidget
{
    protected static ?string $heading = 'Leaderboard Kunjungan User';

    protected function getData(): array
    {
        $users = User::orderByDesc('visit_count')->take(10)->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Kunjungan',
                    'data' => $users->pluck('visit_count')->toArray(),
                ],
            ],
            'labels' => $users->pluck('name')->toArray(),
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}
