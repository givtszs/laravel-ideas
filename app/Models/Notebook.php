<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Notebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator',
        'name',
        'description',
        'cover'
    ];

    public function getCoverUrl(): ?string
    {
        if ($this->cover) {
            return asset('storage/' . $this->cover);
        }

        return "https://loremflickr.com/320/240?random={$this->name}";
    }
}
