<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Main Menu']);
        Category::create(['name' => 'Add-ons']);
        Category::create(['name' => 'Drinks']);
    }
}
