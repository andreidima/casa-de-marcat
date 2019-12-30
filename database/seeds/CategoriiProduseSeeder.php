<?php

use Illuminate\Database\Seeder;

class CategoriiProduseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\CategoriiProduse::insert([
            [
                'nume' => 'Telefoane noi'
            ],
            [
                'nume' => 'Telefoane consignație'
            ],
            [
                'nume' => 'Accesorii telefoane'
            ],
            [
                'nume' => 'Prestări servicii'
            ],
        ]);
    }
}
