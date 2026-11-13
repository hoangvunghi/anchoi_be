<?php

namespace App\Nova\Metrics;

use App\Models\Comment;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalReviews extends Value
{
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Comment::whereNull('parent_id'));
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
        return 'total-reviews';
    }

    public function name()
    {
        return 'Tổng đánh giá';
    }
}
