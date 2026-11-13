<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ChangeSpotStatus extends Action
{
    use Queueable;

    protected string $status;

    public function __construct(string $status, string $name)
    {
        $this->status = $status;
        $this->name = $name; // tên hiển thị + uriKey (3 instance khác tên -> khác key)
    }

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->status = $this->status;
            $model->save();
        }

        return Action::message(count($models) . ' địa điểm đã chuyển sang "' . $this->status . '".');
    }

    public function fields(NovaRequest $request)
    {
        return [];
    }
}
