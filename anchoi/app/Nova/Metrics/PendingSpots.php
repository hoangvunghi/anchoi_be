<?php

namespace App\Nova\Metrics;

use App\Models\EntertainmentSpot;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class PendingSpots extends Value
{
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, EntertainmentSpot::where('status', 'pending'));
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
        return 'pending-spots';
    }

    public function name()
    {
        return 'Chờ duyệt';
    }
}
