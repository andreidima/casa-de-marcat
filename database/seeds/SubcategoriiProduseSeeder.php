<?php

use Illuminate\Database\Seeder;

class SubcategoriiProduseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\SubcategoriiProduse::insert([
            [
                'categorie_produs_id' => '1',
                'nume' => 'Telefoane noi - subcategorie 1'
            ],
            [
                'categorie_produs_id' => '1',
                'nume' => 'Telefoane noi - subcategorie 2'
            ],
            [
                'categorie_produs_id' => '1',
                'nume' => 'Telefoane noi - subcategorie 3'
            ],
            [
                'categorie_produs_id' => '2',
                'nume' => 'Telefoane consignație - subcategorie 1'
            ],
            [
                'categorie_produs_id' => '2',
                'nume' => 'Telefoane consignație - subcategorie 2'
            ],
            [
                'categorie_produs_id' => '2',
                'nume' => 'Telefoane consignație - subcategorie 3'
            ],
            [
                'categorie_produs_id' => '3',
                'nume' => 'Accesorii telefoane - subcategorie 1'
            ],
            [
                'categorie_produs_id' => '3',
                'nume' => 'Accesorii telefoane - subcategorie 2'
            ],
            [
                'categorie_produs_id' => '3',
                'nume' => 'Accesorii telefoane - subcategorie 3'
            ],
            [
                'categorie_produs_id' => '4',
                'nume' => 'Prestări servicii - subcategorie 1'
            ],
            [
                'categorie_produs_id' => '4',
                'nume' => 'Prestări servicii - subcategorie 2'
            ],
            [
                'categorie_produs_id' => '4',
                'nume' => 'Prestări servicii - subcategorie 3'
            ],
        ]);
    }
}
