<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'soras.k.m.tj16@gmail.com',
            'password' => '$2y$10$iJfl1imF0x2MpmvSXOOD7eNtDi1Xkd4QIchcUT5qVK.lobx3PNeMm'
        ]);
    }
}
