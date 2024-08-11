<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

use function PHPUnit\Framework\isNull;

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
        return $this->belongsToMany(User::class, 'notebook_participants')
            ->withTimestamps()
            ->withPivot('role_id')
            ->using(NotebookParticipant::class);
    }

    public function getCoverUrl(): ?string
    {
        if ($this->cover) {
            return asset('storage/' . $this->cover);
        }

        return "https://loremflickr.com/320/240?random={$this->name}";
    }

    public function resolveUserParticipant(): ?NotebookParticipant
    {
        return $this->users()->firstWhere('user_id', Auth::id())?->pivot;
    }
}
