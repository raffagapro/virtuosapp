<?php

namespace Database\Seeders;

use App\Models\Grado;
use Illuminate\Database\Seeder;

class GradoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grado::create([
            'name' => 'kinder 1',
        ]);
        Grado::create([
            'name' => 'kinder 2',
        ]);
        Grado::create([
            'name' => 'kinder 3',
        ]);
        Grado::create([
            'name' => 'primaria 1',
        ]);
        Grado::create([
            'name' => 'primaria 2',
        ]);
        Grado::create([
            'name' => 'primaria 3',
        ]);
        Grado::create([
            'name' => 'primaria 4',
        ]);
        Grado::create([
            'name' => 'primaria 5',
        ]);
        Grado::create([
            'name' => 'primaria 6',
        ]);
        Grado::create([
            'name' => 'secundaria 1',
        ]);
        Grado::create([
            'name' => 'secundaria 2',
        ]);
        Grado::create([
            'name' => 'secundaria 3',
        ]);
    }
}
