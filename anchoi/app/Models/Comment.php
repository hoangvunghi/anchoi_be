<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    
    protected $fillable = [
        'name',
        'email',
        'number_of_star',
        'body',
        'parent_id',
        'entertainment_spot_id',
    ];

    public function entertainmentSpot()
    {
        return $this->belongsTo(EntertainmentSpot::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
