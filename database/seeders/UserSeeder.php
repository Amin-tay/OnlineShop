<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'super-admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
//            'user_type' => '1',
            'phone' => '09999999999',
            'address' => 'Tehran, Tehran, Iran',
        ])->assignRole('superAdmin');

        User::create([
            'name' => 'normal-admin',
            'email' => 'normal-admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
//            'user_type' => '1',
            'phone' => '09999999989',
            'address' => 'Tehran, Tehran, Iran',
        ])->assignRole('normalAdmin');

        User::create([
            'name' => 'User1',
            'email' => 'user1@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
//            'user_type' => '2',
            'phone' => '09999999998',
            'address' => 'Tehran, Tehran, Iran',
        ])->assignRole('normalUser');

        User::create([
            'name' => 'User2',
            'email' => 'user2@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
//            'user_type' => '2',
            'phone' => '09999999997',
            'address' => 'Tehran, Tehran, Iran',
        ])->assignRole('normalUser');
    }
}
