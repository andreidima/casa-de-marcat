<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Produse lipsă</title>
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
    <div style="
        /* border:dashed #999; */
        width:690px;
        min-height:200px;
        padding: 15px 10px 15px 10px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;">

        <table style="">
            <tr style="">
                <td style="border-width:0px; padding:0rem; width:40%">
                        {{-- <img src="{{ asset('images/cropped-gsmobile-logo-red.jpg') }}" width="150px"> --}}
                        G.S.MOBILE 2001 SRL <br>
                        J39/13/2001 <br>
                        RO13648994 <br>
                        GOLESTI,VRANCEA

                </td>
                <td style="border-width:0px; padding:0rem; width:60%; text-align:center; font-size:16px">
                    Neconcordanțe BAZA DE DATE - INVENTAR: {{ \Carbon\Carbon::now()->isoFormat('DD.MM.YYYY') }}
                    <br>
                </td>
            </tr>
        </table>

        <br>
        <br>

            <table style="width:690px;">
                <tr style="background-color:#e7d790;">
                    <th style="width:50px; text-align: center">Nr. Crt.</th>
                    <th style="width:370px; text-align: center">Produs</th>
                    <th style="width:30px; text-align: center">Cod de bare</th>
                    <th style="width:45px; text-align: center">Cant.în baza de date</th>
                    <th style="width:70px; text-align: center">Cantitate la inventar</th>
                </tr>
            @foreach ($produse_lipsa as $produs)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $produs->nume }}
                        </td>
                        <td>
                            {{ $produs->cod_de_bare }}
                        </td>
                        <td class="text-center">
                            {{ $produs->produs_cantitate }}
                        </td>
                        <td class="text-center">
                            {{ $produs->produs_inventar_verificare_cantitate ?? 0 }}
                        </td>
                    </tr>
            @endforeach
                </table>
    </div>
</body>

</html>
