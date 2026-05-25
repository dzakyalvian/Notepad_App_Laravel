<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Note extends Model
{
 protected $fillable = [
    'user_id',
    'title',
    'body',
    'tag',
    'is_favorite',
    'is_pinned',
    'is_deleted',
];

    protected $casts = [
        'is_favorite' => 'boolean',
        'is_deleted'  => 'boolean',
        'is_pinned'   => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope buat filter active notes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_deleted', false);
    }

    // Scope buat filter favorites
    public function scopeFavorites(Builder $query): Builder
    {
        return $query->where('is_favorite', true)->where('is_deleted', false);
    }

    // Scope buat filter trash
    public function scopeTrashed(Builder $query): Builder
    {
        return $query->where('is_deleted', true);
    }

    // Scope buat filter by user
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
