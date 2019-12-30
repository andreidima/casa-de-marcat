<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Raport</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif;  */
            font-size: 12px;
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
            padding: 2px 5px;
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
    <div style="border:dashed #999;
        width:690px; 
        min-height:600px;            
        padding: 15px 10px 15px 10px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;">
                      
        <table style="">
            <tr style="">
                <td style="border-width:0px; padding:0rem; width:40%">
                        <img src="{{ asset('images/cropped-gsmobile-logo-red.jpg') }}" width="150px">
                </td>
                <td style="border-width:0px; padding:0rem; width:60%; text-align:center; font-size:16px">
                    Raport vânzări
                    <br>
                    Pentru data: {{ \Carbon\Carbon::parse($search_data)->isoFormat('D.MM.YYYY') }}
                </td>
            </tr>
        </table>

        <br>
        
        <table style="width:690px;">
            <tr style="background-color:#e7d790;">
                <th style="text-align: center">Nr. crt.</th>
                <th style="text-align: center">Produs</th>
                <th style="text-align: center">Cantitate</th>
                <th style="text-align: center">Preț</th>
            </tr>
            @php 
                // $nrcrt = 1;
                // $nr_persoane = 0;
                // $suma = 0;    
            @endphp
            
            @forelse ($produse_vandute as $produs_vandut) 
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $produs_vandut->produs->nume }}
                    </td>
                    <td style="text-align: right">
                        {{ $produs_vandut->cantitate }}
                    </td>
                    <td style="text-align: right">
                        {{ $produs_vandut->pret }} lei
                    </td>
                </tr>
            @empty
            @endforelse
                <tr>
                    <td colspan="2" style="text-align:right">
                        <b>Total</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ $produse_vandute_nr }}</b>
                    </td>
                    <td style="text-align: right">
                        <b>{{ $produse_vandute_suma_totala }} lei</b> 
                    </td>
                </tr>
        </table>

    </div>
</body>

</html>
    