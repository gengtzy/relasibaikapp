<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    User::create([
        'name' => 'Adminrb',
        'email' => 'admin@relasibaik.com',
        'password' => Hash::make('admin12345'),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
}
}