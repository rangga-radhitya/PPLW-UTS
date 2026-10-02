<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $outlets = Outlet::all();

        foreach ($outlets as $outlet) {
            for ($i = 1; $i <= 10; $i++) {
                Table::create([
                    'outlet_id' => $outlet->id,
                    'table_number' => (string) $i,
                ]);
            }
        }
    }
}
