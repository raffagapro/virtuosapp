<?php

namespace Database\Seeders;

use App\Models\Materia;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UserDevOnlySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maestro = Role::where('name', 'maestro')->first();
        $user1 = new User();
        $user1->name = 'teacher1';
        $user1->email = 'teacher@admin.com';
        $user1->password = '$2y$10$.S01CBGHskwB3Tb7ke/m8OXyz8jbWO7zwd6FYv9ENQP5zRPtLM/gC';
        $user1->status = 1;
        $user1->save();
        $maestro->user()->save($user1);

        $student = Role::where('name', 'estudiante')->first();
        $user2 = new User();
        $user2->name = 'student1';
        $user2->email = 'student@admin.com';
        $user2->password = '$2y$10$.S01CBGHskwB3Tb7ke/m8OXyz8jbWO7zwd6FYv9ENQP5zRPtLM/gC';
        $user2->status = 1;
        $user2->save();
        $student->user()->save($user2);

        $user2a = new User();
        $user2a->name = 'student2';
        $user2a->email = 'student2@admin.com';
        $user2a->password = '$2y$10$.S01CBGHskwB3Tb7ke/m8OXyz8jbWO7zwd6FYv9ENQP5zRPtLM/gC';
        $user2a->status = 1;
        $user2a->save();
        $student->user()->save($user2a);

        $parent = Role::where('name', 'tutor')->first();
        $user3 = new User();
        $user3->name = 'parent1';
        $user3->email = 'parent@admin.com';
        $user3->password = '$2y$10$.S01CBGHskwB3Tb7ke/m8OXyz8jbWO7zwd6FYv9ENQP5zRPtLM/gC';
        $user3->status = 1;
        $user3->save();
        $parent->user()->save($user3);

        $user3a = new User();
        $user3a->name = 'parent2';
        $user3a->email = 'parent2@admin.com';
        $user3a->password = '$2y$10$.S01CBGHskwB3Tb7ke/m8OXyz8jbWO7zwd6FYv9ENQP5zRPtLM/gC';
        $user3a->status = 1;
        $user3a->save();
        $parent->user()->save($user3a);

        $materia = new Materia();
        $materia->name = 'matematicas';
        $materia->save();

        $materia1 = new Materia();
        $materia1->name = 'ingles basico';
        $materia1->save();

        $materia2 = new Materia();
        $materia2->name = 'ingles intermedio';
        $materia2->save();

        $materia3 = new Materia();
        $materia3->name = 'literatura';
        $materia3->save();

        $materia4 = new Materia();
        $materia4->name = 'historia';
        $materia4->save();
    }
}
