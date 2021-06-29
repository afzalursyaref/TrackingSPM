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
            Nomor Agenda : <strong>{{ $verifikasi->agenda->nomor }}</strong>
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
                <form id="form" action="{{ route('verifikasi.store', $verifikasi->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label" for="catatan">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" required
                                    id="catatan" name="catatan" rows="3">{{ old('catatan') ?? $verifikasi->catatan }}</textarea>
                                @error('catatan')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-form-label" for="disposisi_user_id">Teruskan Kepada</label>
                                <select id="disposisi_user_id" name="disposisi_user_id" class="form-control @error('disposisi_user_id') is-invalid @enderror select2bs4 " style="width: 100%;" required>
                                    @foreach ($users as $user)
                                        <option
                                            value="{{ $user->id }}"
                                            @if (old('disposisi_user_id', null) != null)
                                                @if (old('disposisi_user_id') == $user->id)
                                                    selected
                                                @endif
                                            @else
                                                @if ($verifikasi->disposisi_user_id == $user->id)
                                                    selected
                                                @endif
                                            @endif
                                            >
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('disposisi_user_id')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>

@stop

@push('js')
    <script>
        
    </script>
@endpush