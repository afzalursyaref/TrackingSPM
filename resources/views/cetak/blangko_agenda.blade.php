<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belangko Agenda</title>
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/sheets-of-paper/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sheets-of-paper/sheets-of-paper-a4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <style>
        .document{
            font-size:12px;
        }
        @media print {
            .hidden-print {
                display: none !important;
            }
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
    @if ($url = Session::get('backUrl'))
        <div class="hidden-print" style="width:100%; text-align:center; margin-top:20px;">
            <a href="{{ $url }}" class="button">Kembali</a>
        </div>
    @endif

    <div class="page" contenteditable="false">

        <div style="border: 1px solid black; padding:1px; width:100%; font-weight: bold; font-size:14px; border-bottom:none">
            <div style="border: 1px solid black; padding:8px; text-align:center;">
                PEMERINTAH KABUPATEN NAGAN RAYA <br>
                BADAN PENGELOLA KEUANGAN DAERAH
            </div>
        </div>
        <div style="border: 1px solid black; padding:1px; border-bottom:none; border-top:none">
            <table style="border: 1px solid black; width:100%; padding:5px">
                <tr>
                    <td style="font-weight: bold; white-space: pre; width:25%">1. &#x09;SURAT</td>
                    <td>:</td>
                    <td>Asli/Tembusan</td>
                    <td rowspan="8" style="text-align: center; width:140px">
                        <b>Scan Me:</b><br>
                        {!! QrCode::size(100)->generate(route('dashboard.timeline', $agenda->kode)); !!}
                        <br>
                        <b>{{ $agenda->kode }}</b>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; white-space: pre">2. &#x09;AGENDA</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="white-space: pre">&#x09;Tanggal</td>
                    <td>:</td>
                    <td>{{ $agenda->tgl_agenda->format('d-m-Y H:i') }}</td>
                </tr>
                <tr>
                    <td style="white-space: pre">&#x09;Nomor</td>
                    <td>:</td>
                    <td>{{ str_pad($agenda->nomor, 4, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td style="white-space: pre; vertical-align: top">&#x09;Surat Dari</td>
                    <td style="vertical-align: top">:</td>
                    <td>{{ $agenda->skpk->nm_skpk }}</td>
                </tr>
                <tr>
                    <td style="white-space: pre; vertical-align: top">&#x09;No. SPM</td>
                    <td style="vertical-align: top">:</td>
                    <td>{{ $agenda->no_spm }}</td>
                </tr>
                <tr>
                    <td style="white-space: pre; vertical-align: top">&#x09;Jenis SPM</td>
                    <td style="vertical-align: top">:</td>
                    <td>{{ $agenda->jenis_spm }}</td>
                </tr>
                <tr>
                    <td style="white-space: pre; vertical-align: top">&#x09;Nilai SPM</td>
                    <td style="vertical-align: top">:</td>
                    <td>Rp. {{ $agenda->jml_kotor }},-</td>
                </tr>
                <tr>
                    <td style="white-space: pre; vertical-align: top">&#x09;Pemkas / Vendor</td>
                    <td style="vertical-align: top">:</td>
                    <td>{{ $agenda->nm_penerima }} </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-weight: bold; white-space: pre">3. &#x09;DITERUSKAN KEPADA</td>
                </tr>
                <tr>
                    <td style="white-space: pre" colspan="3">&#x09;<i class="far {{ $verifikator_belanja_daerah->id == $agenda->disposisi_user_id ? 'fa-check-square' : 'fa-square' }}"></i> {{ $verifikator_belanja_daerah->profile->jabatan }}</td>
                </tr>
                <tr>
                    <td style="white-space: pre" colspan="3">&#x09;<i class="far {{ $verifikator_penatausahaan->id == $agenda->disposisi_user_id ? 'fa-check-square' : 'fa-square' }}"></i> {{ $verifikator_penatausahaan->profile->jabatan }}</td>
                </tr>
            </table>
        </div>
        <div style="border: 1px solid black; padding:1px; width:100%; border-bottom:none; border-top:none">
            <div style="border: 1px solid black; padding:5px;">
                Dilarang memisahkan sehelai suratpun dari berkas yang tersusun dan surat-surat yang ditujukan supaya disatukan/dilampirkan
            </div>
        </div>
        <div style="border: 1px solid black; padding:1px; width:100%; border-bottom:none; border-top:none">
            <div style="border: 1px solid black; padding:5px;text-align:center; font-weight:bold">
                DISPOSISI
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 2fr; border: 1px solid black; padding:1px; width:100%; border-top:none">
            <div style="border: 1px solid black; padding:15px; border-right:none;">
               <u>Staff Perbendaharaan</u>
               <br>
               @php
                   $no=1;
               @endphp
               @foreach ($users as $user)
                <br>{{ $no++ }}. {{ $user->name }}
               @endforeach
            </div>
            <div style="display:grid; grid-template-rows:1fr 1fr 1fr">
                <div style="border: 1px solid black; padding:5px; height:90px; border-bottom:none;">
                    <u>Kasubbid:</u>
                </div>
                <div style="border: 1px solid black; padding:5px; height:90px; border-bottom:none;">
                    <u>Verifikasi:</u>
                </div>
                <div style="border: 1px solid black; padding:5px; height:90px;">
                    <u>Kabid:</u>
                </div>
            </div>
        </div>

        <div style="border: 1px solid black; padding:1px; width:100%; border-top:none">
            <div style="border: 1px solid black; padding:5px;text-align:left; width:100%">
                <table style="width:100%;">
                    <tr>
                        <td style="width: 100px">Diantar Oleh:</td>
                        <td>:</td>
                        <td>{{ $agenda->dari }}</td>
                        <td style="text-align: right; padding-right:20px"> <i>dinput oleh : {{ $agenda->user_input }}</i> </td>
                    </tr>
                    <tr>
                        <td>No Hp</td>
                        <td>:</td>
                        <td>{{ $agenda->no_hp }}</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

        <hr style="border-top:2px dashed black; margin-top:10px; margin-bottom:20px;"></hr>


        <div style="border: 1px solid black; padding:1px; width:100%; display:grid; grid-template-columns:2fr 1fr">
            <div style="border: 1px solid black; padding:8px;">
                <table style="width:100%;font-weight:bold">
                    <tr>
                        <td style="width: 120px">Nomor Agenda</td>
                        <td style="width: 10px">:</td>
                        <td style="text-align: left">{{ str_pad($agenda->nomor, 4, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td>Diantarkan oleh</td>
                        <td>:</td>
                        <td style="text-align: left">{{ $agenda->dari }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">{{ $agenda->skpk->nm_skpk }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="font-weight: normal; font-style:italic">
                            <br>
                            <small>
                                *) website : {{ url('/') }} <br>
                                **) Scan QR Code disamping untuk melihat data pada website <br>
                                ***) Anda juga dapat mencari data pada website dengan memasukkan kode disamping <br>
                            </small>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="border: 1px solid black; padding:8px;text-align:center; line-height: 1.6;">
                <b>Scan Me:</b><br>
                {!! QrCode::size(100)->generate(route('dashboard.timeline', $agenda->kode)); !!}
                <br>
                <b>{{ $agenda->kode }}</b>
            </div>
        </div>

    </div>


    @if ($url = Session::get('backUrl'))
        <script>
            window.print();
        </script>
    @endif

</body>
</html>
