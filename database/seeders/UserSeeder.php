<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
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
        if (User::all()->count() > 0) {
            return;
        }
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 1,
            'password' => Hash::make('password'),
        ]);
    }
}
