<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $mainMenu = Category::where('name', 'Main Menu')->first()->id;
        $addOns = Category::where('name', 'Add-ons')->first()->id;
        $drinks = Category::where('name', 'Drinks')->first()->id;

        $menus = [
            ['category_id' => $mainMenu, 'name' => 'Chicken Katsu Bowl', 'description' => 'Rice bowl dengan chicken katsu renyah', 'price' => 25000],
            ['category_id' => $mainMenu, 'name' => 'Beef Yakiniku Bowl', 'description' => 'Rice bowl dengan beef yakiniku', 'price' => 28000],
            ['category_id' => $mainMenu, 'name' => 'Chicken Teriyaki Bowl', 'description' => 'Rice bowl dengan chicken teriyaki', 'price' => 25000],
            ['category_id' => $mainMenu, 'name' => 'Spicy Karaage Bowl', 'description' => 'Rice bowl dengan karaage pedas', 'price' => 26000],
            ['category_id' => $mainMenu, 'name' => 'Ebi Furai Bowl', 'description' => 'Rice bowl dengan udang goreng tepung', 'price' => 27000],
            ['category_id' => $addOns, 'name' => 'Gyoza', 'description' => 'Pangsit goreng isi daging, 5 pcs', 'price' => 12000],
            ['category_id' => $addOns, 'name' => 'Karaage Bites', 'description' => 'Potongan ayam goreng crispy', 'price' => 13000],
            ['category_id' => $addOns, 'name' => 'Takoyaki', 'description' => 'Bola tepung isi gurita, 6 pcs', 'price' => 15000],
            ['category_id' => $drinks, 'name' => 'Ocha Tea', 'description' => 'Teh hijau Jepang', 'price' => 8000],
            ['category_id' => $drinks, 'name' => 'Japanese Lychee Tea', 'description' => 'Teh leci ala Jepang', 'price' => 10000],
            ['category_id' => $drinks, 'name' => 'Matcha Latte', 'description' => 'Latte matcha creamy', 'price' => 15000],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
