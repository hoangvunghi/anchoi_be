<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntertainmentSpot extends Model
{
    use HasFactory;

    protected $table = 'diem_vui_choi';

    protected $fillable = [
        'name',
        'entertainment_type_id',
        'ward_id',
        'full_address',
        'phone_number',
        'description',
        'banner_image',
        'price',
        'name_of_owner',
        'status',
        'prefix',
        'slug',
        'additional_info',
        'opening_hours',
        'average_rating',
        'latitude',
        'longitude',
        'distance',
    ];

    public function entertainmentType()
    {
        return $this->belongsTo(EntertainmentType::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function district()
    {
        return $this->hasOneThrough(District::class, Ward::class, 'id', 'id', 'ward_id', 'district_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = $model->slugify($model->name);
            $model->average_rating = $model->calculateAverageRating();
            if ($model->full_address) {
                $coordinates = $model->getCoordinatesFromAddress($model->full_address);
                $model->latitude = $coordinates['lat'];
                $model->longitude = $coordinates['lon'];
            }
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    protected $casts = [
        'distance' => 'double', 
    ];
    public function slugify($string)
    {
        $string = mb_strtolower($string, 'UTF-8');
        $string = str_replace(' ', '-', $string);
        $dict = [
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        ];
        foreach ($dict as $nonUnicode => $uni) {
            $string = preg_replace("/($uni)/i", $nonUnicode, $string);
        }
        // Ensure that the slug is unique by appending the ID if it exists
        if ($this->id) {
            $string .= '-' . $this->id;
        }
        return $string;
    }

    public function getCoordinatesFromAddress(string $fullAddress): ?array
    {
        $geocodingUrl = 'https://nominatim.openstreetmap.org/search?format=json&q=' . urlencode($fullAddress);

        $client = new \GuzzleHttp\Client(
            [
                'headers' => [
                    'User-Agent' => 'MyApp/1.0',
                ],
                "verify" => false,
            ]
        );
        $response = $client->get($geocodingUrl);

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody()->getContents(), true);

            // Assuming the first result is the most accurate
            if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                return [
                    'lat' => (float) $data[0]['lat'],
                    'lon' => (float) $data[0]['lon'],
                ];
            }
        } else {
            return [
                'lat' => 0,
                'lon' => 0,
            ];
        }

        return null;
    }

    public function getAverageRatingAttribute()
    {
        return $this->calculateAverageRating();
    }

    public function calculateAverageRating()
    {
        $comments = $this->comments()->whereNull('parent_id')->get();
        $totalRating = $comments->sum('number_of_star');
        $count = $comments->count();
        if ($count > 0) {
            $avg_rating = $totalRating / $count;
        } else {
            $avg_rating = 0;
        }
        return round($avg_rating, 1);
    }
}
