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
            padding: 2px 2px;
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
            <thead style="background-color:#e7d790;">
                <th>Nr. crt.</th>
                <th>Produs</th>
                <th>Cantitate</th>
                <th>Preț</th>
            </thead>
            @php 
                // $nrcrt = 1;
                // $nr_persoane = 0;
                // $suma = 0;    
            @endphp
            
            <tbody>
                @forelse ($produse_vandute as $produs_vandut) 
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $produs_vandut->produs->nume }}
                        </td>
                        <td>
                            {{ $produs_vandut->cantitate }}
                        </td>
                        <td>
                            {{ $produs_vandut->pret }}
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>

    </div>
</body>

</html>
    