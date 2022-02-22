<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'title' => 'Администратор',
            'slug' => 'admin'
        ]);
        DB::table('roles')->insert([
            'title' => 'Ученик',
            'slug' => 'pupil'
        ]);
        DB::table('users')->insert([
            'name' => 'Pupil',
            'email' => 'pupil@pupil.com',
            'password' => Hash::make('password'),
            'role_id' => Role::firstWhere('slug', 'pupil')->id
        ]);
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'Admin@admin.com',
            'password' => Hash::make('password'),
            'role_id' => Role::firstWhere('slug', 'admin')->id
        ]);
    }
}
