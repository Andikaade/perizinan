<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'name' => 'Admin',
            'nip' => '199001012015011001',
            'title' => 'Administrator',
            'phone' => '081234567890',
            'email' => 'admin.perizinan@sijunjung.go.id',
            'is_admin' => true,
            'is_active' => true,
            'password' => Hash::make('admin123'), 
        ]);
        User::create([
            'username' => 'petugas',
            'name' => 'Petugas',
            'nip' => '199502022020011002',
            'title' => 'Staff',
            'phone' => '081299998888',
            'email' => 'petugas@sijunjung.go.id',
            'is_admin' => false,
            'is_active' => true,
            'password' => Hash::make('admin123'), 
        ]);
    }
}
