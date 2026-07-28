<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['DEV', 'QA', 'RRHH'] as $etiqueta) {
            Tag::firstOrCreate([
                'etiqueta' => $etiqueta,
            ]);
        }
    }
}
