<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Agenda</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sheets-of-paper/bootstrap.min.css') }}" media='all'>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sheets-of-paper/sheets-of-paper-8-13-landscape.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <style>

        .document{
            font-size:12px;
        }

        @media print {
            .hidden-print {
                display: none !important;
            }
            table { page-break-inside:auto }
            tr    { page-break-inside:avoid; page-break-after:auto }
            thead { display:table-header-group }
            tfoot { display:table-footer-group }
        }

        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
    </style>
</head>
<body class="document">

    <div class="page" contenteditable="false">

        <div style="padding:1px; width:100%; font-weight: bold; font-size:14px; margin-bottom:15px">
            <div style="padding:4px; text-align:center;">
                REGISTER AGENDA <br>
            </div>
            <div style="padding:4px; text-align:center;">
                Periode {{ $tgl_1 }} s.d {{ $tgl_2 }}
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="thead text-center">
                <tr>
                    <th class="align-middle">NO. AGENDA</th>
                    <th class="align-middle">TGL AGENDA</th>
                    <th class="align-middle">NOMOR SPM</th>
                    <th class="align-middle">SUB UNIT</th>
                    <th class="align-middle">PEMKAS/VENDOR</th>
                    <th class="align-middle">NILAI SPM</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $data)
                    <tr>
                        <th>{{ str_pad($data->nomor, 4, '0', STR_PAD_LEFT) }}</th>
                        <td class="text-nowrap text-center">{{ $data->tgl_agenda->format('d-m-Y') }}</td>
                        <td>{{ $data->no_spm }}</td>
                        <td>{{ $data->nm_skpk }}</td>
                        <td>{{ $data->nm_penerima }}</td>
                        <td class="text-nowrap text-right">Rp {{ number_format($data->jml_kotor,2,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
    </div>

    <script>
        window.print();
    </script>

</body>
</html>
