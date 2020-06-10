<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Nir</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif;  */
            font-size: 10px;
        }

        * {
            /* padding: 0;
            text-indent: 0; */
        }

        table{
            border-collapse:collapse;
            /* margin: 0px 0px; */
            /* margin-left: 5px; */
            margin-top: 0px;
            border-style: solid;
            border-width:0px;
            width: 100%; 
            word-wrap:break-word;
            /* word-break: break-all; */
            /* table-layout: fixed; */
        }
        
        th, td {
            padding: 0px 5px;
            border-width:1px;
            border-style: solid;
            table-layout:fixed;
            font-weight: normal;
            
        }
        tr {
            /* text-align:; */
            /* border-style: solid;
            border-width:1px; */
        }
        hr { 
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 0.5px;
        } 
    </style>
</head>

<body>
    {{-- Telefoane noi --}}
    {{-- @forelse ($produse_stocuri_telefoane_noi->groupBy('furnizor_id') as $produse_per_furnizor)
    @forelse ($produse_per_furnizor->groupBy('nr_factura') as $produse_per_factura) --}}
    @forelse ($niruri_telefoane_noi->groupBy('nir') as $nir)
    {{-- @forelse ($nir as $nir_produs_stoc) --}}

        @php
            $total_suma_achizitie = 0;
            $total_suma_tva = 0;
            $total_suma_vanzare = 0;
        @endphp

        <div style="
            border:dashed #999;
            width:1000px; 
            min-height:600px;            
            padding: 0px 10px 15px 10px;
            margin:0px 0px;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                border-radius: 10px;">

                      
            <table style="">
                <tr style="">
                    <td style="border-width:0px; padding:0rem; width:40%">
                            {{-- <img src="{{ asset('images/cropped-gsmobile-logo-red.jpg') }}" width="150px"> --}}
                            UNITATEA <br>
                            G.S.MOBILE 2001 SRL <br>
                            J39/13/2001 <br>
                            RO13648994 <br>
                            FOCSANI, JUD. VRANCEA <br>
                            PCT LUCRU STEFAN CEL MARE, NR.5

                    </td>
                    <td style="border-width:0px; padding:0rem; width:60%; text-align:center;">
                        <h2 style="margin:0px 0px 5px 0px"><b>NOTA DE RECEPTIE SI CONSTATARE DIFERENTE</b></h2>
                        <table style="width:250px; margin-left:auto; margin-right:auto; text-align:center">
                            <tr>
                                <td rowspan="2">
                                    Numar document
                                </td>
                                <td>
                                    Data
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Zi
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $nir->first()->nir }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($search_data)->isoFormat('D.MM.YYYY') }}
                                </td>
                            </tr>
                        </table>
                        <br><br>
                    </td>
                </tr>
                <tr style="">
                    <td colspan="2" style="border-width:0px; text-align:center">
                        Se receptioneaza marfurile furnizate de {{ $nir->first()->produs_stoc->furnizor->nume ?? '"furnizor nu este specificat"' }}, din localitatea {{ $nir->first()->produs_stoc->furnizor->localitate ?? '"localitatea furnizorului nu este specificată"' }}
                        <br>
                        conform facturii nr {{ $nir->first()->produs_stoc->nr_factura ?? '"nu este specificată"'}}, din data de {{ \Carbon\Carbon::parse($search_data)->isoFormat('D.MM.YYYY') }}
                    </td>
                </tr>
            </table>

            <br>

            
                    <table style="width:1000px;">
                        <tr style="background-color:#e7d790;">
                            <th style="width:50px; text-align: center">Nr. Crt.</th>
                            <th style="width:425px; text-align: center">Produs</th>
                            <th style="width:30px; text-align: center">UM</th>
                            <th style="width:45px; text-align: center">Cant.</th>
                            <th style="width:70px; text-align: center">Preț achiziție</th>
                            <th style="width:70px; text-align: center">Valoare</th>
                            <th style="width:70px; text-align: center">TVA</th>
                            <th style="width:70px; text-align: center">Pret Vanzare</th>
                            <th style="width:70px; text-align: center">Total</th>
                        </tr>
                            
                            @forelse ($nir as $nir_produs_stoc)         
                                <tr>                  
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $nir_produs_stoc->produs_stoc->produs->nume ?? '' }}
                                    </td>
                                    <td>
                                        buc
                                    </td>
                                    <td style="text-align:right;">
                                        {{ $nir_produs_stoc->produs_stoc->cantitate ?? '' }}
                                    </td>
                                    <td style="text-align:right;">
                                        {{ $nir_produs_stoc->produs_stoc->pret_de_achizitie ? number_format(round(($nir_produs_stoc->produs_stoc->pret_de_achizitie / 1.19), 2) , 2) : '' }}
                                    </td>
                                    <td style="text-align:right;">
                                        @isset($nir_produs_stoc->produs_stoc->pret_de_achizitie)
                                            {{ number_format(round(($nir_produs_stoc->produs_stoc->pret_de_achizitie / 1.19), 2) * $nir_produs_stoc->produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_achizitie += round(($nir_produs_stoc->produs_stoc->pret_de_achizitie / 1.19), 2) * $nir_produs_stoc->produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>
                                    <td style="text-align:right;">
                                        @isset($nir_produs_stoc->produs_stoc->pret_de_achizitie)
                                            {{ number_format(round(($nir_produs_stoc->produs_stoc->pret_de_achizitie * 0.19), 2) * $nir_produs_stoc->produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_tva += round(($nir_produs_stoc->produs_stoc->pret_de_achizitie * 0.19), 2) * $nir_produs_stoc->produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>
                                    <td style="text-align:right;">
                                        {{ $nir_produs_stoc->produs_stoc->produs->pret ?? '' }}
                                    </td>
                                    <td style="text-align:right;">
                                        @isset($nir_produs_stoc->produs_stoc->produs->pret)
                                            {{ $nir_produs_stoc->produs_stoc->produs->pret * $nir_produs_stoc->produs_stoc->cantitate }} 
                                            @php 
                                                $total_suma_vanzare += $nir_produs_stoc->produs_stoc->produs->pret * $nir_produs_stoc->produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>                             
                                </tr> 
                            @empty
                                <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div>
                            @endforelse
                                <tr>
                                    <td colspan="5"  style="text-align:right;">
                                        Total
                                    </td>
                                    <td  style="text-align:right;">
                                        {{ $total_suma_achizitie }}
                                    </td>
                                    <td  style="text-align:right;">
                                        {{ $total_suma_tva }}
                                    </td>
                                    <td></td>
                                    <td  style="text-align:right;">
                                        {{ $total_suma_vanzare }}
                                    </td> 
                                </tr>
                    </table>

                    <br><br>
                    
                    <table style="width:1000px; text-align:center; page-break-inside:avoid;">
                        <tr>
                            <td colspan="2" style="width:40%">
                                COMISIA DE RECEPTIE
                            </td>
                            <td rowspan="3" style="width:20%"></td>
                            <td colspan="2" style="width:40%">
                                PRIMIT IN GESTIUNE
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Numele si prenumele
                            </td>
                            <td>
                                Semnatura
                            </td>
                            <td>
                                Data
                            </td>
                            <td rowspan="2"  style="width:20%">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                VERDEATA IULIA
                            </td>
                            <td>

                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($search_data)->isoFormat('D.MM.YYYY') }}
                            </td>
                        </tr>
                    </table> 
        </div>   

        @if(!$loop->last)
            <p style="page-break-after: always;"></p>  
        @endif
    @empty
    @endforelse


    {{-- Page break dupa ultimul nir de la telefoane --}}
    @if($niruri_telefoane_noi->isNotEmpty())
        <p style="page-break-after: always;"></p>
    @endif

    
    {{-- Accesorii --}}
    @forelse ($niruri_accesorii->groupBy('nir') as $nir)

        @php
            $total_suma_achizitie = 0;
            $total_suma_tva = 0;
            $total_suma_vanzare = 0;
        @endphp

        <div style="
            border:dashed #999;
            width:1000px; 
            min-height:600px;            
            padding: 0px 10px 15px 10px;
            margin:0px 0px;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                border-radius: 10px;">

                      
            <table style="">
                <tr style="">
                    <td style="border-width:0px; padding:0rem; width:40%">
                            {{-- <img src="{{ asset('images/cropped-gsmobile-logo-red.jpg') }}" width="150px"> --}}
                            UNITATEA <br>
                            G.S.MOBILE 2001 SRL <br>
                            J39/13/2001 <br>
                            RO13648994 <br>
                            FOCSANI, JUD. VRANCEA <br>
                            PCT LUCRU STEFAN CEL MARE, NR.5

                    </td>
                    <td style="border-width:0px; padding:0rem; width:60%; text-align:center;">
                        <h2 style="margin:0px 0px 5px 0px"><b>NOTA DE RECEPTIE SI CONSTATARE DIFERENTE</b></h2>
                        <table style="width:250px; margin-left:auto; margin-right:auto; text-align:center">
                            <tr>
                                <td rowspan="2">
                                    Numar document
                                </td>
                                <td>
                                    Data
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Zi
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $nir->first()->nir }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($search_data)->isoFormat('D.MM.YYYY') }}
                                </td>
                            </tr>
                        </table>
                        <br><br>
                    </td>
                </tr>
                <tr style="">
                    <td colspan="2" style="border-width:0px; text-align:center">
                        Se receptioneaza marfurile furnizate de {{ $nir->first()->produs_stoc->furnizor->nume ?? '"furnizor nu este specificat"' }}, din localitatea {{ $nir->first()->produs_stoc->furnizor->localitate ?? '"localitatea furnizorului nu este specificată"' }}
                        <br>
                        conform facturii nr {{ $nir->first()->produs_stoc->nr_factura ?? '"nu este specificată"'}}, din data de {{ \Carbon\Carbon::parse($search_data)->isoFormat('D.MM.YYYY') }}
                    </td>
                </tr>
            </table>

            <br>

            
                    <table style="width:1000px;">
                        <tr style="background-color:#e7d790;">
                            <th style="width:50px; text-align: center">Nr. Crt.</th>
                            <th style="width:425px; text-align: center">Produs</th>
                            <th style="width:30px; text-align: center">UM</th>
                            <th style="width:45px; text-align: center">Cant.</th>
                            <th style="width:70px; text-align: center">Preț achiziție</th>
                            <th style="width:70px; text-align: center">Valoare</th>
                            <th style="width:70px; text-align: center">TVA</th>
                            {{-- <th style="width:70px; text-align: center">Pret Vanzare</th>
                            <th style="width:70px; text-align: center">Total</th> --}}
                        </tr>
                            
                            @forelse ($nir as $nir_produs_stoc)         
                                <tr>                  
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $nir_produs_stoc->produs_stoc->produs->nume ?? '' }}
                                    </td>
                                    <td>
                                        buc
                                    </td>
                                    <td style="text-align:right;">
                                        {{ $nir_produs_stoc->produs_stoc->cantitate ?? '' }}
                                    </td>
                                    <td style="text-align:right;">
                                        {{ $nir_produs_stoc->produs_stoc->pret_de_achizitie ? number_format(round(($nir_produs_stoc->produs_stoc->pret_de_achizitie / 1.19), 2) , 2) : '' }}
                                    </td>
                                    <td style="text-align:right;">
                                        @isset($nir_produs_stoc->produs_stoc->pret_de_achizitie)
                                            {{ number_format(round(($nir_produs_stoc->produs_stoc->pret_de_achizitie / 1.19), 2) * $nir_produs_stoc->produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_achizitie += round(($nir_produs_stoc->produs_stoc->pret_de_achizitie / 1.19), 2) * $nir_produs_stoc->produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>
                                    <td style="text-align:right;">
                                        @isset($nir_produs_stoc->produs_stoc->pret_de_achizitie)
                                            {{ number_format(round(($nir_produs_stoc->produs_stoc->pret_de_achizitie * 0.19), 2) * $nir_produs_stoc->produs_stoc->cantitate , 2) }} 
                                            @php 
                                                $total_suma_tva += round(($nir_produs_stoc->produs_stoc->pret_de_achizitie * 0.19), 2) * $nir_produs_stoc->produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>
                                    {{-- <td style="text-align:right;">
                                        {{ $nir_produs_stoc->produs_stoc->produs->pret ?? '' }}
                                    </td>
                                    <td style="text-align:right;">
                                        @isset($nir_produs_stoc->produs_stoc->produs->pret)
                                            {{ $nir_produs_stoc->produs_stoc->produs->pret * $nir_produs_stoc->produs_stoc->cantitate }} 
                                            @php 
                                                $total_suma_vanzare += $nir_produs_stoc->produs_stoc->produs->pret * $nir_produs_stoc->produs_stoc->cantitate
                                            @endphp
                                        @endisset
                                    </td>                              --}}
                                </tr> 
                            @empty
                                <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div>
                            @endforelse
                                <tr>
                                    <td colspan="5"  style="text-align:right;">
                                        Total
                                    </td>
                                    <td  style="text-align:right;">
                                        {{ $total_suma_achizitie }}
                                    </td>
                                    <td  style="text-align:right;">
                                        {{ $total_suma_tva }}
                                    </td>
                                    {{-- <td></td>
                                    <td  style="text-align:right;">
                                        {{ $total_suma_vanzare }}
                                    </td>  --}}
                                </tr>
                    </table>

                    <br><br>
                    
                    <table style="width:1000px; text-align:center; page-break-inside:avoid;">
                        <tr>
                            <td colspan="2" style="width:40%">
                                COMISIA DE RECEPTIE
                            </td>
                            <td rowspan="3" style="width:20%"></td>
                            <td colspan="2" style="width:40%">
                                PRIMIT IN GESTIUNE
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Numele si prenumele
                            </td>
                            <td>
                                Semnatura
                            </td>
                            <td>
                                Data
                            </td>
                            <td rowspan="2"  style="width:20%">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                VERDEATA IULIA
                            </td>
                            <td>

                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($search_data)->isoFormat('D.MM.YYYY') }}
                            </td>
                        </tr>
                    </table> 
        </div>   

        @if(!$loop->last)
            <p style="page-break-after: always;"></p>  
        @endif
    @empty
    @endforelse
</body>

</html>
    