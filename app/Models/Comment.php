<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    protected $fillable = ['comment', 'client_id', 'post_id'];

    public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }

}
