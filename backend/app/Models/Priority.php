<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $fillable = [
        'prioridad',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'prioridad_id');
    }
}
