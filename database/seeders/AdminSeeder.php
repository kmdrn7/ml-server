<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Admin::create([
            'serial' => Str::uuid(),
            'nama' => 'ML Server ADMIN',
            'email' => 'admin@mlserver.com',
            'password' => Hash::make('adminadmin'),
        ]);
    }
}
