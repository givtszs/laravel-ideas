<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'profile_picture'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function ideas(): HasMany
    {
        return $this->hasMany(Idea::class)->latest();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follower_user', 'user_id', 'follower_id')->withTimestamps();
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follower_user', 'follower_id', 'user_id')->withTimestamps();
    }

    public function follows(User $user)
    {
        return $this->followings()->where('user_id', $user->id)->exists();
    }

    public function likedIdeas(): BelongsToMany
    {
        return $this->belongsToMany(Idea::class, 'idea_like')->withTimestamps();
    }

    public function doesLikeIdea(Idea $idea)
    {
        return $this->likedIdeas()->where('idea_id', $idea->id)->exists();
    }

    public function getProfilePictureUrl()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }

        return "https://api.dicebear.com/9.x/croodles/svg?seed={$this->name}";
    }

    public static function topUsers(): Collection
    {
        return User::withCount('ideas')
            ->orderBy('ideas_count', 'DESC')
            ->limit(5)
            ->get();

        // TODO: Invalidate cache upon database data changes
        // return Cache::remember('topUsers', now()->addHour(), function () {
        // });
    }
}
