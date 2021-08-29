<?php

namespace Database\Seeders;

use App\Models\Modalidad;
use Illuminate\Database\Seeder;

class ModalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modalidad::create([
            'name' => 'presencial',
        ]);
        Modalidad::create([
            'name' => 'flexischool',
        ]);
        Modalidad::create([
            'name' => 'homeschooling',
        ]);
        Modalidad::create([
            'name' => 'distancia',
        ]);
        Modalidad::create([
            'name' => 'grupo de estudio',
        ]);
    }
}
