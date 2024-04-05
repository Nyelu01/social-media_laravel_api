<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasUuids;

    //If you want to override/specify the custom name of table to be used
    // public $table = 'table_name';

    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'user_id'
    ];

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id');
    }
    public function created_by() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
