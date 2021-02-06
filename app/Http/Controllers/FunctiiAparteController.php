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
        // echo 'Total produse in subcategoria Folii protectie = ' . $produse->count();
        // echo '<br><br>';

        echo 'Produsele modificate sunt:';
        echo '<br><br>';
        echo '<table style="border: 1px solid black;">
            <tr>
                <td>Nume</td>
                <td>Barcode</td>
                <td>Pret vechi</td>            
                <td>Pret nou</td>
            </tr>';
        foreach ($produse as $produs){
            switch ($produs->pret) {
                case '15':
                    $produs->pret = 5; 
                    $produs->save();
                    echo 
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '15' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                        '</tr>';
                    break;
                case '55':
                    $produs->pret = 40;
                    $produs->save();
                    echo
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '55' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                            '</tr>';
                    break;
                case '70':
                    $produs->pret = 55;
                    $produs->save();
                    echo
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '70' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                            '</tr>';
                    break;
                case '65':
                    $produs->pret = 50;
                    $produs->save();
                    echo
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '65' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                            '</tr>';
                    break;
                case '20':
                    $produs->pret = 10;
                    $produs->save();
                    echo
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '20' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                            '</tr>';
                    break;
                case '90':
                    $produs->pret = 70;
                    $produs->save();
                    echo
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '90' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                            '</tr>';
                    break;
                case '25':
                    $produs->pret = 15;
                    $produs->save();
                    echo
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '25' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                            '</tr>';
                    break;
                case '60':
                    $produs->pret = 45;
                    $produs->save();
                    echo
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '60' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                            '</tr>';
                    break;
                case '45':
                    $produs->pret = 30;
                    $produs->save();
                    echo
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '45' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                            '</tr>';
                    break;
                case '35':
                    $produs->pret = 20;
                    $produs->save();
                    echo
                        '<tr>' .
                            '<td>' . $produs->nume . '</td>' .
                            '<td>' . $produs->cod_de_bare . '</td>' .
                            '<td style="text-align:right">' . '35' . '</td>' .
                            '<td style="text-align:right">' . $produs->pret . '</td>' .
                            '</tr>';
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
