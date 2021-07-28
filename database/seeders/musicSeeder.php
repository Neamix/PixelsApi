<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class musicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \App\Models\Music::factory(10)->create(); 
    }
}
