<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Idea extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'notebook_id'];
    protected $with = ['user', 'comments.user'];
    protected $withCount = ['likes'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'idea_like')->withTimestamps();
    }

    public function scopeSearch(Builder $query, string $searchInput): void
    {
        $query->where('content', 'LIKE', '%' . $searchInput . '%');
    }
}
