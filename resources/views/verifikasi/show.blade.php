@extends('adminlte::page')

@section('title', 'Catatan Verifikasi')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Tambah Agenda</h1> --}}
@stop

@section('content')
<div class="row">
    <div class="col-12">
    <div class="callout callout-info">
        <h5>
            Nomor Agenda : <strong>{{ str_pad($verifikasi->agenda->nomor, 4, '0', STR_PAD_LEFT) }}</strong>
            <small class="float-right">Tanggal: {{ $verifikasi->agenda->tgl_agenda }}</small>
        </h5>
        Kode : <b>{{ $verifikasi->agenda->kode }}</b>
    </div>

    <div class="invoice p-3 mb-3">
        <div class="row">
            <div class="col-12">
                <h4>
                    Nomor SPM : {{ $verifikasi->agenda->no_spm }}
                    <small class="float-right">Tanggal: {{ $verifikasi->agenda->tgl_spm }}</small>
                </h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <b>{{ $verifikasi->agenda->skpk->nm_skpk }}</b>
                <div>
                    <i>"{{ $verifikasi->agenda->uraian }}"</i>
                </div>
                Jenis SPM : <b>{{ $verifikasi->agenda->jenis_spm }}</b> <br/>
                Sumber Dana : <b>{{ $verifikasi->agenda->sumberdana }}</b> <br/>
            </div>

            <div class="col-sm-4">
                Penerima:
                <div>
                    <strong>{{ $verifikasi->agenda->nm_penerima }}</strong><br>
                    {{ $verifikasi->agenda->bank_penerima }}<br>
                    {{ $verifikasi->agenda->rek_penerima }}
                </div>
            </div>

            <div class="col-sm-4 text-right">
                <br>
                <b>Jumlah Kotor:</b> Rp. {{ $verifikasi->agenda->jml_kotor }}<br>
                <b>Potongan:</b> Rp. {{ $verifikasi->agenda->potongan }}<br>
                <b>Jumlah Bersih:</b> Rp. {{ $verifikasi->agenda->jml_bersih }}
            </div>

        </div>

        <div class="row mt-2">
            <div class="col-sm-12">
                <form>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label" for="catatan">Catatan</label>
                                <textarea class="form-control" readonly
                                    id="catatan" name="catatan" rows="3">{{ $verifikasi->catatan }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-form-label" for="disposisi_user_id">Teruskan Kepada</label>
                                <input id="disposisi_user_id" type="text" class="form-control"  value="{{ $verifikasi->disposisi_user->name }}" readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
@stop
