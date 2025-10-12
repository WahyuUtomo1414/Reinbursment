<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Str;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\ReinbursementDetail;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class ReimbursementCategoryChart extends ChartWidget
{
    use HasWidgetShield;
    
    protected ?string $heading = 'Reimbursement Category Chart';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = ReinbursementDetail::query()
            ->select(['id_category', DB::raw('COUNT(*) as total')])
            ->with('category:id,name')
            ->groupBy('id_category')
            ->get();

        $labels = $data->map(fn ($item) => $item->category?->name ?? 'Unknown')->toArray();
        $values = $data->map(fn ($item) => $item->total)->toArray();

        // Generate warna random
        $colors = [
            '#36A2EB', // biru
            '#FF6384', // merah muda
            '#FFCE56', // kuning
            '#4BC0C0', // hijau toska
            '#9966FF', // ungu
            '#FF9F40', // oranye
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Total Reimbursements',
                    'data' => $values,
                    'backgroundColor' => $colors,
                    'hoverOffset' => 10,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
