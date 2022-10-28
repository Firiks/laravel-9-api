<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Customer::factory()
        ->count(25)
        ->hasInvoices(10) // relationship
        ->create();

      Customer::factory()
        ->count(100)
        ->hasInvoices(5) // relationship
        ->create();

        Customer::factory()
        ->count(100)
        ->hasInvoices(3) // relationship
        ->create();

        Customer::factory()
        ->count(5)
        ->create();
    }
}
