<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Lista inventar</title>
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
    {{-- <div style="width:730px; height: 1030px; border-style: dashed ; border-width:2px; border-radius: 15px;">      --}}
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
                                XXXX
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
                    {{-- <br> --}}
                    Se receptioneaza marfurile furnizate de XXXXXXXXXXXXXXXXXXXXXXXXXXX, din localitatea XXXXXXX
                    <br>
                    conform facturii nr XXXXXXXXX, din data de {{ \Carbon\Carbon::parse($search_data)->isoFormat('D.MM.YYYY') }}
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
                          
                        @forelse ($produse_intrate->groupby('produs_id') as $produse_grupate_dupa_id)         
                            <tr>                  
                                <td align="">
                                    {{-- {{ ($produse_intrate ->currentpage()-1) * $produse_intrate ->perpage() + $loop->index + 1 }} --}}
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{-- <b>{{ $produs->nume ?? '' }}</b> --}}
                                    {{ ($produse_grupate_dupa_id->first()->nume) }}
                                </td>
                                <td>
                                    buc
                                </td>
                                <td style="text-align: right">
                                    {{ $produse_grupate_dupa_id->sum('cantitate') - $produse_grupate_dupa_id->sum('cantitate_initiala')}}
                                </td>
                                <td style="text-align: right">
                                    {{ $produse_grupate_dupa_id->first()->pret_de_achizitie ? round(($produse_grupate_dupa_id->first()->pret_de_achizitie / 1.19), 2) : '' }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produse_grupate_dupa_id->first()->pret_de_achizitie ? 
                                        (
                                            round(($produse_grupate_dupa_id->first()->pret_de_achizitie / 1.19), 2) 
                                            * 
                                            ($produse_grupate_dupa_id->sum('cantitate') - $produse_grupate_dupa_id->sum('cantitate_initiala'))
                                        ) : '' }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produse_grupate_dupa_id->first()->pret_de_achizitie ? 
                                        (
                                            round(($produse_grupate_dupa_id->first()->pret_de_achizitie * 0.19), 2) 
                                            * 
                                            ($produse_grupate_dupa_id->sum('cantitate') - $produse_grupate_dupa_id->sum('cantitate_initiala'))
                                        ) : '' }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produse_grupate_dupa_id->first()->pret }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produse_grupate_dupa_id->first()->pret ? 
                                        (
                                            $produse_grupate_dupa_id->first()->pret 
                                            * 
                                            ($produse_grupate_dupa_id->sum('cantitate') - $produse_grupate_dupa_id->sum('cantitate_initiala'))
                                        ) : '' }}
                                </td>                                
                            </tr>  
                        @empty
                            <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div>
                        @endforelse
                            <tr style="font-weight:bold">
                                <td colspan="5" style="text-align: right">
                                    <b>TOTAL<b>
                                </td>
                                <td style="text-align: right">
                                    <b>{{ round($produse_intrate->sum('total_suma_achizitie'), 2) }}</b>
                                </td>
                                <td style="text-align: right">
                                    <b>{{ round($produse_intrate->sum('total_suma_tva'), 2) }}</b>
                                </td>
                                <td></td>
                                <td style="text-align: right">
                                    <b>{{ round($produse_intrate->sum('total_suma_vanzare'), 2) }}</b>
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
</body>

</html>
    