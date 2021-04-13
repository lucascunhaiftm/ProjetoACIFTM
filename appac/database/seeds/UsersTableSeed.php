<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $supervisorRole = Role::where('name', 'supervisor')->first();
        $studentRole = Role::where('name', 'student')->first();

        $admin = User::create([
            'name' => 'Admin user',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ]);

        $student = User::create([
            'name' => 'Student user',
            'email' => 'student@student.com',
            'password' => Hash::make('student123')
        ]);

        $supervisor = User::create([
            'name' => 'Supervisor user',
            'email' => 'supervisor@supervisor.com',
            'password' => Hash::make('supervisor123')
        ]);

        $admin->roles()->attach($adminRole);
        $student->roles()->attach($studentRole);
        $supervisor->roles()->attach($supervisorRole);
    }
}
