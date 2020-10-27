<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Raport gestiune accesorii</title>
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
    

        <div style="
            border:dashed #999;
            width:680px; 
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
                        <br>
                        <h2 style="margin:0px 0px 5px 0px"><b>RAPORT GESTIUNE ACCESORII</b></h2>

                        <b>
                            {{ \Carbon\Carbon::parse($search_data)->isoFormat('DD.MM.YYYY') }}
                        </b>
                        <br><br>
                    </td>
                </tr>
            </table>

            <br>

            
                    <table style="width:680px;">
                        <tr style="background-color:#e7d790;">
                            <th style="width:40px; text-align: center">Nr. Crt.</th>
                            <th style="width:100px; text-align: center">Număr document</th>
                            <th style="width:250px; text-align: center">Explicații</th>
                            <th style="width:70px; text-align: center">Valoare lei</th>
                            <th style="width:150px; text-align: center">Ambalaje</th>
                        </tr>

                        {{-- <tr style="background-color:#e7d790;">
                            <td colspan="5" style="text-align: left">
                                <b>Sold precedent</b>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right">
                                {{ $suma_gestiune_accesorii }}
                            </td>
                            <td></td>
                        </tr> --}}

                        <tr style="background-color:#e7d790;">
                            <td colspan="5" style="text-align: left">
                                <b>Intrări</b>
                            </td>
                        </tr>
                            
                        @php
                            $total_total_suma_vanzare = 0;
                        @endphp
                        @foreach ($niruri_accesorii->groupBy('nir') as $nir)
                            @php
                                $total_suma_vanzare = 0;
                            @endphp

                            @foreach ($nir as $nir_produs_stoc)   
                                @isset($nir_produs_stoc->produs_stoc->produs->pret)
                                    {{-- {{ $nir_produs_stoc->produs_stoc->produs->pret * $nir_produs_stoc->produs_stoc->cantitate }}  --}}
                                    @php 
                                        $total_suma_vanzare += $nir_produs_stoc->produs_stoc->produs->pret * $nir_produs_stoc->produs_stoc->cantitate
                                    @endphp
                                @endisset
                            @endforeach

                            @php
                                $total_total_suma_vanzare += $total_suma_vanzare;
                            @endphp

                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                NIR NR {{ $nir->first()->nir }}
                            </td>
                            <td>

                            </td>
                            <td style="text-align: right">
                                {{ $total_suma_vanzare }}
                            </td>
                            <td>

                            </td>
                        </tr>

                        @endforeach

                        <tr>
                            <td colspan="3" style="text-align: right">
                                <b>Total</b>
                            </td>
                            <td style="text-align: right">
                                <b>{{ $total_total_suma_vanzare }}</b>
                            </td>
                            <td>
                                
                            </td>
                        </tr>


                        <tr style="background-color:#e7d790;">
                            <td colspan="5" style="text-align: left">
                                <b>Ieșiri</b>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                Vânzări
                            </td>
                            <td>

                            </td>
                            <td style="text-align: right">
                                {{ $produse_vandute_suma }}
                            </td>
                            <td>

                            </td>
                        </tr>

                        <tr style="background-color:#e7d790;">
                            <td colspan="5" style="text-align: left">
                                <b>
                                    Sold în program
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                {{ \Carbon\Carbon::now()->isoFormat('DD.MM.YYYY HH:mm') }}
                            </td>
                            <td></td>
                            <td style="text-align: right">
                                {{ $suma_gestiune_accesorii }}
                            </td>
                            <td></td>
                        </tr>


                    </table>

                    <br><br>
                    
        </div>   

</body>

</html>
    