<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $configs = [
            [
                'serial' => Str::uuid(),
                'key' => 'disk_size',
                'value' => '1000', // GB
            ],
            [
                'serial' => Str::uuid(),
                'key' => 'is_maintenance',
                'value' => '0',
            ],
        ];
        Config::insert($configs);
    }
}
