<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\PendingSpots;
use App\Nova\Metrics\SpotsByStatus;
use App\Nova\Metrics\TotalReviews;
use App\Nova\Metrics\TotalSpots;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new TotalSpots,
            new PendingSpots,
            new TotalReviews,
            new SpotsByStatus,
        ];
    }
}
