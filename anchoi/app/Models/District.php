<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = 'quan_huyen';

    protected $fillable = [
        'name',
        'province_id',
        'slug',
        'prefix'
    ];

    /**
     * Relationship to the Province model
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Relationship to the Ward model
     */
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }

    /**
     * Boot method for the model
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = $model->slugify($model->name);
        });
    }

    /**
     * Slugify the name of the district
     */
    function slugify($string)
    {
        $string = mb_strtolower($string, 'UTF-8');
        $string = str_replace(' ', '-', $string);
        $dict = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        );
        foreach ($dict as $nonUnicode => $uni) {
            // thay thế các ký tự có dấu bằng ký tự không dấu
            $string = preg_replace("/($uni)/i", $nonUnicode, $string);
        }
        return $string;
    }
}
