@extends('adminlte::page')

@section('title', 'AGENDA')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Tambah Agenda</h1> --}}
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="callout callout-info">
            <h5>
                Nomor Agenda : <strong>{{ $agenda->nomor }}</strong>
                <small class="float-right">Tanggal: {{ $agenda->tgl_agenda }}</small>
            </h5>
            <hr>
            <div class="row">
                
                <div class="col-sm-3 mt-2">Dari : <br><b>{{ $agenda->dari }} <br> ({{ $agenda->no_hp }})</b></div>
                <div class="col-sm-3 mt-2">Diinput Oleh : <br><b>{{ $agenda->user_input }}</b></div>
                <div class="col-sm-3 mt-2">
                    Diteruskan Kpd : <br>
                    <b>{{ $agenda->disposisi_user->name }}</b>
                    @if ($agenda->disposisi_user->profile()->exists())
                        <br>({{ $agenda->disposisi_user->profile->jabatan }})
                    @endif
                </div>
                <div class="col-sm-3 text-center mt-2">
                    {!! QrCode::size(75)->generate(route('dashboard.timeline', $agenda->kode)); !!}
                    <br>
                    <b>{{ $agenda->kode }}</b>
                </div>
            </div>
        </div>

        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                        Nomor SPM : {{ $agenda->no_spm }}
                        <small class="float-right">Tanggal: {{ $agenda->tgl_spm }}</small>
                    </h4>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <b>{{ $agenda->skpk->nm_skpk }}</b>
                    <div>
                        <i>"{{ $agenda->uraian }}"</i>
                    </div>
                    Jenis SPM : <b>{{ $agenda->jenis_spm }}</b> <br/>
                    Sumber Dana : <b>{{ $agenda->sumberdana }}</b> <br/>
                </div>
            
                <div class="col-sm-4">
                    Penerima:
                    <div>
                        <strong>{{ $agenda->nm_penerima }}</strong><br>
                        {{ $agenda->bank_penerima }}<br>
                        {{ $agenda->rek_penerima }}
                    </div>
                </div>
            
                <div class="col-sm-4 text-right">
                    <b>Jumlah Kotor:</b> Rp. {{ $agenda->jml_kotor }}<br>
                    <b>Potongan:</b> Rp. {{ $agenda->potongan }}<br>
                    <b>Jumlah Bersih:</b> Rp. {{ $agenda->jml_bersih }}<br>
                </div>
            
            </div>
        </div>

    </div>
</div>

@stop
