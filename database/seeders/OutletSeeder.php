<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    public function run(): void
    {
        Outlet::create(['name' => 'BowlMate Kampus A', 'address' => 'Jl. Kampus A No. 1', 'open_hours' => '08:00 - 20:00', 'phone' => '081234567001']);
        Outlet::create(['name' => 'BowlMate Kampus B', 'address' => 'Jl. Kampus B No. 1', 'open_hours' => '08:00 - 20:00', 'phone' => '081234567002']);
        Outlet::create(['name' => 'BowlMate Kampus C', 'address' => 'Jl. Kampus C No. 1', 'open_hours' => '08:00 - 20:00', 'phone' => '081234567003']);
    }
}
