<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner',
        ]);
        $teacherRole = Role::create([
            'name' => 'teacher',
        ]);
        $studentRole = Role::create([
            'name' => 'student',
        ]);

        $userOwner = User::create([
            'name' => 'RyuuAdmin',
            'occupation' => 'SuperAdmin',
            'avatar' => 'images/default-avatar.png',
            'email' => 'ryuuadmin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $userOwner->assignRole($ownerRole);
    }
}
