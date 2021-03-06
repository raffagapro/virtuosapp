<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'super admin',
        ]);
    
        Role::create([
            'name' => 'admin',
        ]);

        Role::create([
            'name' => 'coordinador',
        ]);
    
        Role::create([
            'name' => 'maestro',
        ]);
    
        Role::create([
            'name' => 'tutor',
        ]);
    
        Role::create([
            'name' => 'estudiante',
        ]);
    
        Role::create([
        'name' => 'guest',
        ]);
    }
}
