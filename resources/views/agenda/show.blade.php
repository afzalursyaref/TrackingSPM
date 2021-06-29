@extends('adminlte::page')

@section('title', 'Agenda')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Tambah Agenda</h1> --}}
@stop

@section('content')
    <div class="row">
        <div class="col-sm-9">
            <div class="card">
                <div class="card-header bg-primary">
                    Data Agenda
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="nomor">Nomor</label>
                                    <input id="nomor" name="nomor" type="text" 
                                        class="form-control @error('nomor') is-invalid @enderror" 
                                        value="{{ $agenda->nomor }}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="kode">Kode</label>
                                    <input id="kode" name="kode" type="text" 
                                        class="form-control @error('kode') is-invalid @enderror" 
                                        value="{{ $agenda->kode }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="dari">Nama Pemberi Berkas</label>
                                    <input id="dari" name="dari" type="text" 
                                        class="form-control" 
                                        value="{{ $agenda->dari }}" readonly >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="no_hp">Nomor HP</label>
                                    <input id="no_hp" name="no_hp" type="text" 
                                        class="form-control" 
                                        value="{{ $agenda->no_hp }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="tgl_agenda">Tanggal Agenda</label>
                                    <input id="tgl_agenda" name="tgl_agenda" type="text" 
                                        class="form-control" 
                                        value="{{ $agenda->tgl_agenda }}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="skpk_id">SKPK</label>
                                    <input id="skpk" name="skpk" type="text" 
                                        class="form-control" 
                                        value="{{ $agenda->skpk->nm_skpk }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="input_group_no_spm">Nomor SPM</label>
                                    <input id="no_spm" name="no_spm" type="text" 
                                        class="form-control" 
                                        value="{{ $agenda->no_spm }}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="tgl_spm">Tanggal SPM</label>
                                    <input id="tgl_spm" name="tgl_spm" type="text" 
                                        class="form-control" 
                                        value="{{ $agenda->tgl_spm }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="uraian">Uraian</label>
                                    <textarea class="form-control" readonly
                                        id="uraian" name="uraian" rows="3">{{ $agenda->uraian }}</textarea>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-form-label" for="nm_penerima">Nama Penerima</label>
                                    <input id="nm_penerima" name="nm_penerima" type="text" 
                                        class="form-control " 
                                        value="{{ $agenda->nm_penerima }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="bank_penerima">Bank Penerima</label>
                                    <input id="bank_penerima" name="bank_penerima" type="text" 
                                        class="form-control " 
                                        value="{{ $agenda->bank_penerima }}" readonly >
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="rek_penerima">Rekening Penerima</label>
                                    <input id="rek_penerima" name="rek_penerima" type="text" 
                                        class="form-control " 
                                        value="{{ $agenda->rek_penerima }}" readonly >
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="npwp">NPWP</label>
                                    <input id="npwp" name="npwp" type="text" 
                                        class="form-control" 
                                        value="{{ $agenda->npwp }}" readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label " for="jml_kotor">Jumlah Kotor</label>
                                    <input id="jml_kotor" name="jml_kotor" type="text" 
                                        class="form-control text-right" 
                                        value="{{ $agenda->jml_kotor }}" readonly >
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="potongan">Potongan</label>
                                    <input id="potongan" name="potongan" type="text" 
                                        class="form-control text-right" 
                                        value="{{ $agenda->potongan }}" readonly >
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="jml_bersih">Jumlah Bersih</label>
                                    <input id="jml_bersih" name="jml_bersih" type="text" 
                                        class="form-control text-right @error('jml_bersih') is-invalid @enderror" 
                                        value="{{ $agenda->jml_bersih }}" readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Jenis SPM :</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio1" name="jenis_spm" disabled value="UP" {{ ($agenda->jenis_spm == 'UP') ? 'checked' : '' }}>
                                        <label for="customRadio1" class="custom-control-label">UP</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio2" name="jenis_spm" disabled value="GU" {{ ($agenda->jenis_spm == 'GU') ? 'checked' : '' }}>
                                        <label for="customRadio2" class="custom-control-label" >GU</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio3" name="jenis_spm" disabled value="TU" {{ ($agenda->jenis_spm == 'TU') ? 'checked' : '' }}>
                                        <label for="customRadio3" class="custom-control-label" >TU</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio4" name="jenis_spm" disabled value="LS.GJ" {{ ($agenda->jenis_spm == 'LS.GJ') ? 'checked' : '' }}>
                                        <label for="customRadio4" class="custom-control-label" >LS GAJI</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio5" name="jenis_spm" disabled value="LS.NON-GJ" {{ ($agenda->jenis_spm == 'LS.NON-GJ') ? 'checked' : '' }}>
                                        <label for="customRadio5" class="custom-control-label" >LS NON-GAJI</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio6" name="jenis_spm" disabled value="LS.BJ" {{ ($agenda->jenis_spm == 'LS.BJ') ? 'checked' : '' }}>
                                        <label for="customRadio6" class="custom-control-label" >LS Barang Jasa</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio7" name="jenis_spm" disabled value="LS.PPKD" {{ ($agenda->jenis_spm == 'LS.PPKD') ? 'checked' : '' }}>
                                        <label for="customRadio7" class="custom-control-label" >LS PPKD</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Sumber Dana :</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radioSumberDana1" name="sumberdana" disabled value="APBK" {{ ($agenda->sumberdana == 'APBK') ? 'checked' : '' }}>
                                        <label for="radioSumberDana1" class="custom-control-label" >APBK</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radioSumberDana2" name="sumberdana" disabled value="DAK-FISIK" {{ ($agenda->sumberdana == 'DAK-FISIK') ? 'checked' : '' }}>
                                        <label for="radioSumberDana2" class="custom-control-label">DAK FISIK</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radioSumberDana3" name="sumberdana" disabled value="DAK-NON-FISIK" {{ ($agenda->sumberdana == 'DAK-NON-FISIK') ? 'checked' : '' }}>
                                        <label for="radioSumberDana3" class="custom-control-label">DAK NON FISIK</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radioSumberDana4" name="sumberdana" disabled value="OTSUS" {{ ($agenda->sumberdana == 'OTSUS') ? 'checked' : '' }}>
                                        <label for="radioSumberDana4" class="custom-control-label">OTSUS</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radioSumberDana5" name="sumberdana" disabled value="DID" {{ ($agenda->sumberdana == 'DID') ? 'checked' : '' }}>
                                        <label for="radioSumberDana5" class="custom-control-label">DID</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radioSumberDana6" name="sumberdana" disabled value="DID-TAMBAHAN" {{ ($agenda->sumberdana == 'DID-TAMBAHAN') ? 'checked' : '' }}>
                                        <label for="radioSumberDana6" class="custom-control-label">DID TAMBAHAN</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="radioSumberDana7" name="sumberdana" disabled value="BANTUAN-KEUANGAN" {{ ($agenda->sumberdana == 'BANTUAN-KEUANGAN') ? 'checked' : '' }}>
                                        <label for="radioSumberDana7" class="custom-control-label">BANTUAN KEUANGAN</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="col-sm-3 text-center">
            <b>Scan Me:</b><br>
            {!! QrCode::size(150)->generate(route('dashboard.timeline', $agenda->kode)); !!}
            <br>
            <b>{{ $agenda->kode }}</b>
        </div>
    </div>    
@stop
