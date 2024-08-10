<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class Notebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'name',
        'description',
        'cover'
    ];

    protected $withCount = ['ideas', 'users'];

    public function ideas(): HasMany
    {
        return $this->hasMany(Idea::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('role_id');
    }

    public function getCoverUrl(): ?string
    {
        if ($this->cover) {
            return asset('storage/' . $this->cover);
        }

        return "https://loremflickr.com/320/240?random={$this->name}";
    }

    public function getUserRole(): ?Role
    {
        if (!Auth::check()) {
            return null;
        }

        $roleId = $this->users()->firstWhere('user_id', Auth::id())->pivot->role_id;
        return Role::firstWhere('id', $roleId);
    }
}
