<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FunctiiAparteController extends Controller
{
    /**
     * Modificarea preturilor produselor din subcategoria „Folii protectie”
     *
     * Printarea listei cu produsele modificate pentru contabilitate.
     */
    public function schimbareAutomataDePreturi(){
        $produse = \App\Produs::select('id', 'nume', 'pret', 'subcategorie_produs_id', 'cod_de_bare')
            ->where('subcategorie_produs_id', 14) // subcategoria pentru Folii protectie
            ->get();
        echo '
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>';
        echo 'Total produse in subcategoria Folii protectie = ' . $produse->count();
        echo '<br><br>';

        echo 'Produsele modificate sunt:';
        echo '<br><br>';
        echo '<table style="border: 1px solid black;">
            <tr>
                <td>ID</td>
                <td>Nume</td>
                <td>Barcode</td>
                <td>Pret vechi</td>            
                <td>Pret nou</td>
            </tr>';
        foreach ($produse as $produs){
            switch ($produs->pret) {
                case '9':
                    $produs->pret = 10; 
                    $produs->save();
                    echo 
                        '<tr>' .
                            '<td>' . $produs->id . '</td>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '9' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                        '</tr>';
                    break;
                case '24':
                    $produs->pret = 25;
                    $produs->save();
                    echo '<tr><td>', 'Nume';
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        echo '</table>';

        // dd($produse->count(), $produse_modificate);
    }
}
