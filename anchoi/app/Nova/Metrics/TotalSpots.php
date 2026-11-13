<?php

namespace App\Nova\Metrics;

use App\Models\EntertainmentSpot;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalSpots extends Value
{
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, EntertainmentSpot::class);
    }

    public function ranges()
    {
        return [];
    }

    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    public function uriKey()
    {
        return 'total-spots';
    }

    public function name()
    {
        return 'Tổng địa điểm';
    }
}
