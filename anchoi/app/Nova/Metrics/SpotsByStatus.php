<?php

namespace App\Nova\Metrics;

use App\Models\EntertainmentSpot;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class SpotsByStatus extends Partition
{
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, EntertainmentSpot::class, 'status')
            ->label(function ($value) {
                return [
                    'pending' => 'Chờ duyệt',
                    'approved' => 'Đã duyệt',
                    'rejected' => 'Từ chối',
                ][$value] ?? ($value ?: 'Khác');
            })
            ->colors([
                'pending' => '#f59e0b',
                'approved' => '#22c55e',
                'rejected' => '#ef4444',
            ]);
    }

    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    public function uriKey()
    {
        return 'spots-by-status';
    }

    public function name()
    {
        return 'Địa điểm theo trạng thái';
    }
}
