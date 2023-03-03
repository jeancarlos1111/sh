<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'cedula' => 'V987654321',
            'nombre' => 'Admin',
            'apellido' => 'Root',
            'email' => 'adminroot@mail.com',
            'password' => Hash::make('1234567890')
        ]);

        $user->assignRole('adminroot', 'admin');
    }
}
