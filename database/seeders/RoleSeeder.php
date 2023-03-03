<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'adminroot']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'jefe_piso']);
        Role::create(['name' => 'supervisor']);
        Role::create(['name' => 'deposito']);
        Role::create(['name' => 'despacho']);
    }
}
