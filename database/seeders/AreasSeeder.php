<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'name' => 'ciencias',
        ]);
        Area::create([
            'name' => 'idiomas',
        ]);
        Area::create([
            'name' => 'artes',
        ]);
        Area::create([
            'name' => 'academicas',
        ]);
    }
}
