<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key' => 'delivery_price',
            'value' => '7000'
        ]);
        Setting::create([
            'key' => 'delivery_price_office',
            'value' => '15000'
        ]);
        Setting::create([
            'key' => 'delivery_price_courier',
            'value' => '15000'
        ]);
        Setting::create([
            'key' => 'delivery_price_courier_tashkent',
            'value' => '15000'
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
