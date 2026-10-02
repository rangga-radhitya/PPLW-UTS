<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $outlets = Outlet::all();

        // 1 akun staff per outlet
        foreach ($outlets as $index => $outlet) {
            User::create([
                'name' => 'Staff ' . $outlet->name,
                'email' => 'staff.' . chr(97 + $index) . '@bowlmate.test', // staff.a@, staff.b@, staff.c@
                'password' => Hash::make('password'),
                'role' => 'staff',
                'outlet_id' => $outlet->id,
            ]);
        }

        // 1 akun customer buat tes
        User::create([
            'name' => 'Customer Tes',
            'email' => 'customer@bowlmate.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
