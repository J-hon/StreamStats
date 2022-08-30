<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
