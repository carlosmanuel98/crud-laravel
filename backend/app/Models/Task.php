<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'fecha_vencimiento',
        'prioridad_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha_vencimiento' => 'date:Y-m-d',
        ];
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class, 'prioridad_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
