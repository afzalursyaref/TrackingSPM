@extends('adminlte::page')

@section('title', 'Catatan Pengelola')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Tambah Agenda</h1> --}}
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="callout callout-info">
            <h5>
                Nomor Agenda : <strong>{{ $pengelola->verifikasi->agenda->nomor }}</strong>
                <small class="float-right">Tanggal: {{ $pengelola->verifikasi->agenda->tgl_agenda->format('d-m-Y H:i') }}</small>
            </h5>
            Kode : <b>{{ $pengelola->verifikasi->agenda->kode }}</b>
        </div>

        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                        Nomor SPM : {{ $pengelola->verifikasi->agenda->no_spm }}
                        <small class="float-right">Tanggal: {{ $pengelola->verifikasi->agenda->tgl_spm }}</small>
                    </h4>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <b>{{ $pengelola->verifikasi->agenda->skpk->nm_skpk }}</b>
                    <div>
                        <i>"{{ $pengelola->verifikasi->agenda->uraian }}"</i>
                    </div>
                    Jenis SPM : <b>{{ $pengelola->verifikasi->agenda->jenis_spm }}</b> <br/>
                    Sumber Dana : <b>{{ $pengelola->verifikasi->agenda->sumberdana }}</b> <br/>
                </div>
            
                <div class="col-sm-4">
                    Penerima:
                    <div>
                        <strong>{{ $pengelola->verifikasi->agenda->nm_penerima }}</strong><br>
                        {{ $pengelola->verifikasi->agenda->bank_penerima }}<br>
                        {{ $pengelola->verifikasi->agenda->rek_penerima }}
                    </div>
                </div>
            
                <div class="col-sm-4 text-right">
                    <b>Jumlah Kotor:</b> Rp. {{ $pengelola->verifikasi->agenda->jml_kotor }}<br>
                    <b>Potongan:</b> Rp. {{ $pengelola->verifikasi->agenda->potongan }}<br>
                    <b>Jumlah Bersih:</b> Rp. {{ $pengelola->verifikasi->agenda->jml_bersih }}<br>
                </div>
            
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-12">
                    <b>Catatan Verifikator</b><br/>
                    {{ $pengelola->verifikasi->catatan }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <h5>Catatan Pengelola</h5>
                @if (count($pengelola->detailPengelola) > 0)
                    @foreach ($pengelola->detailPengelola()->orderBy('created_at','desc')->get() as $item)
                        <div class="callout callout-warning">
                            <h5>
                                {{ $item->catatan }}
                                <small class="float-right text-muted">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() }}</small>
                            </h5>
                            {{-- <button type="button" class="btn bg-gradient-danger btn-xs btn-hapus-catatan" data-id="{{ $item->id }}">Hapus</button> --}}
                        </div>
                    @endforeach
                @else
                    <small class="text-danger">Empty</small>
                @endif
            </div>
        </div>

    </div>
</div>

@stop
