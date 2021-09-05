<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create([
            'name' => 'Air Minum',
            'slug' => 'air-minum',
            'created_by' => 'Admin',
            'updated_by' => 'Admin'
        ]);
    }
}
