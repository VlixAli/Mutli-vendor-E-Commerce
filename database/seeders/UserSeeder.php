<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Jerry Seinfeld' ,
            'email' => 'jerrySeinfeld@gmail.com' ,
            'password' => Hash::make('password'),
            'phone_number' => '912881992',
        ]);

        DB::table('users')->insert([
            'name' => 'George Costanza' ,
            'email' => 'georgeCostanza@gmail.com' ,
            'password' => Hash::make('password'),
            'phone_number' => '912881992',
        ]);
    }
}
