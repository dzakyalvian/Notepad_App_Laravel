<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id', 'title', 'body', 'tag', 'is_favorite', 'is_deleted'
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
        'is_deleted'  => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
