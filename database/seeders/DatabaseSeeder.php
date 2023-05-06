<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::firstOrCreate([
            'email' => 'test@app.com'
        ], [
            'name' => 'Test User',
            'password' => bcrypt(12345678),
        ]);

        Product::factory(100)->create();
    }
}
