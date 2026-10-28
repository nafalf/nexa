<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $customer=\App\Models\User::create(['name'=>'Ardi Pratama','email'=>'demo@nexa.id','password'=>\Illuminate\Support\Facades\Hash::make('Nexa1234'),'role'=>'customer']); $admin=\App\Models\User::create(['name'=>'Admin Nexa','email'=>'admin@nexa.id','password'=>\Illuminate\Support\Facades\Hash::make('Nexa1234'),'role'=>'admin']); $customer->accounts()->create(['name'=>'Nexa Tabungan','number'=>'0223383830','balance'=>28000000,'type'=>'tabungan']); $customer->beneficiaries()->createMany([['name'=>'Yogie','bank'=>'Nexa Bank','number'=>'0102030405'],['name'=>'Putri','bank'=>'Nexa Bank','number'=>'0504030201']]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
