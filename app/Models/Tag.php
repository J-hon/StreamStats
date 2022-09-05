<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'description'
    ];

    public function streams(): BelongsToMany
    {
        return $this->belongsToMany(Stream::class);
    }
}
