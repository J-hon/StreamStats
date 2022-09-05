<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'game_id',
        'game_name',
        'viewer_count',
        'started_at'
    ];

    protected $casts = [
        'started_at' => 'datetime'
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
