<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $table = 'xa_phuong';

    protected $fillable = [
        'name', 'district_id', 'slug', 'prefix'
    ];

    /**
     * Relationship to the District model
     */
    public function district()
    {
        return $this->belongsTo(District::class);
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
     * Slugify the name of the ward
     */
    function slugify($string) {
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
