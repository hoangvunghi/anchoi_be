<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use App\Models\District;
use App\Models\Ward;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\FormData;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Mostafaznv\NovaCkEditor\CkEditor;

class EntertainmentSpot extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\EntertainmentSpot>
     */
    public static $model = \App\Models\EntertainmentSpot::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            BelongsTo::make('Entertainment Type')
                ->sortable(),

                BelongsTo::make('Ward')
                    ->sortable()
                    ->searchable(),
                    
            Text::make('Full Address')
                ->nullable(),

            Text::make('Phone Number')
                ->nullable(),

            CkEditor::make(trans('Description'), 'description')->stacked()
            ->rules('required'),
            
            Image::make('Banner Image')
                ->disk('public')
                ->storeAs(function (Request $request) {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($request->file('banner_image')->getRealPath());
                    $imageName = time() . '.' . $request->banner_image->extension();
                    $imagePath = 'images/' . $imageName; 
                    $image->save(storage_path('app/public/' . $imagePath)); 
                    return $imagePath; 
                })
                ->prunable(),

            Number::make('Price')
                ->nullable(),

            Text::make('Name Of Owner')
                ->nullable(),

            Text::make("additional_info")
                ->nullable(),
            Text::make("opening_hours")
            ->rules('required'),
            Select::make('Status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->displayUsingLabels()
                ->rules('required'),
            Number::make(__('Average Rating'), 'average_rating')
            ->readonly() // Chỉ cho phép xem
            ->sortable(),
            // 'latitude', 'longitude',
            Text::make('Latitude')
                ->nullable()
                ->readonly(),
            Text::make('Longitude')
                ->nullable()
                ->readonly(),
            // slug
            Slug::make('Slug')
                ->from('Name')
                ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
