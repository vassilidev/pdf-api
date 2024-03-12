<?php

namespace App\Filament\Resources\ContractResource\Widgets;

use App\Models\Contract;
use Filament\Widgets\ChartWidget;

class ContractChart extends ChartWidget
{
    protected static ?string $heading = 'Contract per days';

    protected function getData(): array
    {
        $contracts = Contract::selectRaw('DATE_FORMAT(created_at, "%d/%m/%Y") as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $labels = $contracts->pluck('date')->toArray();
        $data = $contracts->pluck('count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Contract this day',
                    'data'  => $data,
                ],
            ],
            'labels'   => $labels
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
