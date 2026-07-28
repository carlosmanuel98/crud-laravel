<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['BAJA', 'MEDIA', 'ALTA'] as $prioridad) {
            Priority::firstOrCreate([
                'prioridad' => $prioridad,
            ]);
        }
    }
}
