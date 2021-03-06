<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = Role::where('name', 'super admin')->first();

        $user1 = new User();

        $user1->name = 'admin';
        $user1->username = 'admin';
        $user1->email = 'admin@admin.com';
        $user1->password = '$2y$10$.S01CBGHskwB3Tb7ke/m8OXyz8jbWO7zwd6FYv9ENQP5zRPtLM/gC';
        $user1->status = 1;
        $user1->save();
        $super_admin->user()->save($user1);

        $admin = Role::where('name', 'admin')->first();

        $user2 = new User();

        $user2->name = 'jacqueline lopez luna';
        $user2->username = 'jadmin';
        $user2->email = 'jadmin@admin.com';
        $user2->password = '$2y$10$.S01CBGHskwB3Tb7ke/m8OXyz8jbWO7zwd6FYv9ENQP5zRPtLM/gC';
        $user2->status = 1;
        $user2->save();
        $admin->user()->save($user2);
    }
}
