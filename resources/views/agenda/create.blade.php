@extends('adminlte::page')

@section('title', 'Agenda')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Tambah Agenda</h1> --}}
@stop

@push('css')
    <style>
        .modal-dialog .overlay{
            text-align:center;
            line-height:2;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-9">
            <div class="card">
                <div class="card-header bg-primary">
                    Form Agenda
                </div>
                <div class="card-body">

                    <form id="form" action="{{ route('agenda.store') }}" method="POST" >
                        @csrf
                        <div class="row">
                            {{-- <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="nomor">Nomor</label>
                                    <input id="nomor" name="nomor" type="text"
                                        class="form-control @error('nomor') is-invalid @enderror"
                                        value="{{ old('nomor') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="kode">Kode</label>
                                    <input id="kode" name="kode" type="text"
                                        class="form-control @error('kode') is-invalid @enderror"
                                        value="{{ old('kode') }}" required>
                                </div>
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="dari">Nama Pemberi Berkas</label>
                                    <input id="dari" name="dari" type="text"
                                        class="form-control @error('dari') is-invalid @enderror"
                                        value="{{ old('dari') }}" required>
                                    @error('dari')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="no_hp">Nomor HP</label>
                                    <input id="no_hp" name="no_hp" type="text"
                                        class="form-control @error('no_hp') is-invalid @enderror"
                                        value="{{ old('no_hp') }}">
                                    @error('no_hp')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="tgl_agenda">Tanggal Agenda</label>
                                    <div class="input-group date" id="tgl_agenda" data-target-input="nearest">
                                        <input type="text" class="form-control @error('tgl_agenda') is-invalid @enderror
                                            datetimepicker-input" name="tgl_agenda" data-target="#tgl_agenda" value="{{ old('tgl_agenda') }}" required/>
                                        <div class="input-group-append" data-target="#tgl_agenda" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        @error('tgl_agenda')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="skpk_id">SKPK</label>
                                    <select id="skpk_id" name="skpk_id" class="form-control select2bs4 @error('skpk_id') is-invalid @enderror" style="width: 100%;" required>
                                        @foreach ($skpk as $skpk)
                                            <option {{ $loop->first ?? 'selected = selected' }}
                                                value="{{ $skpk->id }}"
                                                data-urusan="{{ $skpk->kd_urusan }}"
                                                data-bidang="{{ $skpk->kd_bidang }}"
                                                data-unit="{{ $skpk->kd_unit }}"
                                                data-sub="{{ $skpk->kd_sub }}"
                                                {{ (old('skpk_id') == $skpk->id) ? 'selected' : '' }}>
                                                {{ $skpk->nm_skpk }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('skpk_id')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="input_group_no_spm">Nomor SPM</label>
                                    <div id="input_group_no_spm" class="input-group">
                                        <input id="no_spm" name="no_spm" type="text" class="form-control @error('no_spm') is-invalid @enderror" value="{{ old('no_spm') }}" readonly required>
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-danger"
                                                id="tarik_data"
                                                data-attr="{{ route('spm_all') }}"
                                                >Tarik Data</button>
                                        </div>
                                        @error('no_spm')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="tgl_spm">Tanggal SPM</label>
                                    <div class="input-group date" id="tgl_spm" data-target-input="nearest">
                                        <input type="text" class="form-control @error('tgl_spm') is-invalid @enderror datetimepicker-input"
                                            name="tgl_spm" data-target="#tgl_spm" value="{{ old('tgl_spm') }}" readonly required/>
                                        <div class="input-group-append" data-target="#tgl_spm" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('tgl_spm')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="uraian">Uraian</label>
                                    <textarea class="form-control @error('uraian') is-invalid @enderror" readonly required
                                        id="uraian" name="uraian" rows="3">{{ old('uraian') }}</textarea>
                                    @error('uraian')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="col-form-label" for="nm_penerima">Nama Penerima</label>
                                    <input id="nm_penerima" name="nm_penerima" type="text"
                                        class="form-control @error('nm_penerima') is-invalid @enderror"
                                        value="{{ old('nm_penerima') }}" readonly required>
                                    @error('nm_penerima')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="bank_penerima">Bank Penerima</label>
                                    <input id="bank_penerima" name="bank_penerima" type="text"
                                        class="form-control @error('bank_penerima') is-invalid @enderror"
                                        value="{{ old('bank_penerima') }}" readonly required>
                                    @error('bank_penerima')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="rek_penerima">Rekening Penerima</label>
                                    <input id="rek_penerima" name="rek_penerima" type="text"
                                        class="form-control @error('rek_penerima') is-invalid @enderror"
                                        value="{{ old('rek_penerima') }}" readonly required>
                                    @error('rek_penerima')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="npwp">NPWP</label>
                                    <input id="npwp" name="npwp" type="text"
                                        class="form-control @error('npwp') is-invalid @enderror"
                                        value="{{ old('npwp') }}" readonly required>
                                    @error('npwp')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label " for="jml_kotor">Jumlah Kotor</label>
                                    <input id="jml_kotor" name="jml_kotor" type="text"
                                        class="form-control text-right @error('jml_kotor') is-invalid @enderror"
                                        value="{{ old('jml_kotor') }}" readonly required>
                                    @error('jml_kotor')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="potongan">Potongan</label>
                                    <input id="potongan" name="potongan" type="text"
                                        class="form-control text-right @error('potongan') is-invalid @enderror"
                                        value="{{ old('potongan') }}" readonly required>
                                    @error('potongan')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="jml_bersih">Jumlah Bersih</label>
                                    <input id="jml_bersih" name="jml_bersih" type="text"
                                        class="form-control text-right @error('jml_bersih') is-invalid @enderror"
                                        value="{{ old('jml_bersih') }}" readonly required>
                                    @error('jml_bersih')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Jenis SPM :</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('jenis_spm') is-invalid @enderror" type="radio" id="customRadio1" name="jenis_spm" value="UP" {{ (old('jenis_spm') == 'UP') ? 'checked' : '' }}>
                                        <label for="customRadio1" class="custom-control-label">UP</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('jenis_spm') is-invalid @enderror" type="radio" id="customRadio2" name="jenis_spm" value="GU" {{ (old('jenis_spm') == 'GU') ? 'checked' : '' }}>
                                        <label for="customRadio2" class="custom-control-label" >GU</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('jenis_spm') is-invalid @enderror" type="radio" id="customRadio3" name="jenis_spm" value="TU" {{ (old('jenis_spm') == 'TU') ? 'checked' : '' }}>
                                        <label for="customRadio3" class="custom-control-label" >TU</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('jenis_spm') is-invalid @enderror" type="radio" id="customRadio4" name="jenis_spm" value="LS.GJ" {{ (old('jenis_spm') == 'LS.GJ') ? 'checked' : '' }}>
                                        <label for="customRadio4" class="custom-control-label" >LS GAJI</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('jenis_spm') is-invalid @enderror" type="radio" id="customRadio5" name="jenis_spm" value="LS.NON-GJ" {{ (old('jenis_spm') == 'LS.NON-GJ') ? 'checked' : '' }}>
                                        <label for="customRadio5" class="custom-control-label" >LS NON-GAJI</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('jenis_spm') is-invalid @enderror" type="radio" id="customRadio6" name="jenis_spm" value="LS.BJ" {{ (old('jenis_spm') == 'LS.BJ') ? 'checked' : '' }}>
                                        <label for="customRadio6" class="custom-control-label" >LS Barang Jasa</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('jenis_spm') is-invalid @enderror" type="radio" id="customRadio6" name="jenis_spm" value="LS.BJ-Perencanaan" {{ (old('jenis_spm') == 'LS.BJ-Perencanaan') ? 'checked' : '' }}>
                                        <label for="customRadio6" class="custom-control-label" >LS Barang Jasa - Perencanaan</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('jenis_spm') is-invalid @enderror" type="radio" id="customRadio6" name="jenis_spm" value="LS.BJ-Pengawasan" {{ (old('jenis_spm') == 'LS.BJ-Pengawasan') ? 'checked' : '' }}>
                                        <label for="customRadio6" class="custom-control-label" >LS Barang Jasa - Pengawasan</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('jenis_spm') is-invalid @enderror" type="radio" id="customRadio7" name="jenis_spm" value="LS.PPKD" {{ (old('jenis_spm') == 'LS.PPKD') ? 'checked' : '' }}>
                                        <label for="customRadio7" class="custom-control-label" >LS PPKD</label>
                                    </div>
                                    @error('jenis_spm')
                                        <span class="error invalid-feedback" style='display: inline'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Sumber Dana :</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('sumberdana') is-invalid @enderror" type="radio" id="radioSumberDana1" name="sumberdana" value="APBK" {{ (old('sumberdana') == 'APBK') ? 'checked' : '' }}>
                                        <label for="radioSumberDana1" class="custom-control-label" >APBK</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('sumberdana') is-invalid @enderror" type="radio" id="radioSumberDana2" name="sumberdana" value="DAK-FISIK" {{ (old('sumberdana') == 'DAK-FISIK') ? 'checked' : '' }}>
                                        <label for="radioSumberDana2" class="custom-control-label">DAK FISIK</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('sumberdana') is-invalid @enderror" type="radio" id="radioSumberDana3" name="sumberdana" value="DAK-NON-FISIK" {{ (old('sumberdana') == 'DAK-NON-FISIK') ? 'checked' : '' }}>
                                        <label for="radioSumberDana3" class="custom-control-label">DAK NON FISIK</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('sumberdana') is-invalid @enderror" type="radio" id="radioSumberDana4" name="sumberdana" value="OTSUS" {{ (old('sumberdana') == 'OTSUS') ? 'checked' : '' }}>
                                        <label for="radioSumberDana4" class="custom-control-label">OTSUS</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('sumberdana') is-invalid @enderror" type="radio" id="radioSumberDana5" name="sumberdana" value="DID" {{ (old('sumberdana') == 'DID') ? 'checked' : '' }}>
                                        <label for="radioSumberDana5" class="custom-control-label">DID</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('sumberdana') is-invalid @enderror" type="radio" id="radioSumberDana6" name="sumberdana" value="DID-TAMBAHAN" {{ (old('sumberdana') == 'DID-TAMBAHAN') ? 'checked' : '' }}>
                                        <label for="radioSumberDana6" class="custom-control-label">DID TAMBAHAN</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input @error('sumberdana') is-invalid @enderror" type="radio" id="radioSumberDana7" name="sumberdana" value="BANTUAN-KEUANGAN" {{ (old('sumberdana') == 'BANTUAN-KEUANGAN') ? 'checked' : '' }}>
                                        <label for="radioSumberDana7" class="custom-control-label">BANTUAN KEUANGAN</label>
                                    </div>
                                    @error('sumberdana')
                                        <span class="error invalid-feedback" style='display: inline'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="disposisi_user_id">Teruskan Kepada</label>
                                    <select id="disposisi_user_id" name="disposisi_user_id" class="form-control @error('disposisi_user_id') is-invalid @enderror select2bs4 " style="width: 100%;" required>
                                        @foreach ($users as $user)
                                            <option
                                                value="{{ $user->id }}"
                                                {{ (old('disposisi_user_id') == $user->id) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('disposisi_user_id')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input id="cetak" name="cetak" class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Cetak Dokumen</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 text-sm-right">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-overlay" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-xl" >
          <div class="modal-content">
            {{-- <div class="modal-header">
                <h4 class="modal-title">Connecting...</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}
            <div class="modal-body">
                <table id="example1" class="table table-bordered table-striped display nowrap">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>No SPM</th>
                            <th>Tgl SPM</th>
                            <th>Uraian</th>
                            <th>Nama Penerima</th>
                            <th>Bank Penerima</th>
                            <th>Rek Penerima</th>
                            <th>NPWP</th>
                            <th>Jml Kotor</th>
                            <th>Potongan</th>
                            <th>Jml Bersih</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="modal-danger" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Error!</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Gagal Menghubungkan ke Server SIMDA. <br> Harap Menghubungi Administrator</p>
            </div>
          </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        // $(document).ready(function() {
        //     $('#tgl_agenda').datetimepicker({ icons: { time: 'far fa-clock' } });
        // });

        var table;

        $(document).ready(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('#tgl_agenda').datetimepicker({
                format: 'DD-MM-YYYY HH:mm',
                icons: { time: 'far fa-clock' }
            });

            $('#tgl_spm').datetimepicker({
                format: 'DD-MM-YYYY'
            });

        });

        $('#skpk_id').on('select2:select', function (e) {
            // var data = e.params.data;
            // console.log(data);
            document.getElementById('no_spm').value = '';
            $('#tgl_spm').datetimepicker('date', '');
            document.getElementById('uraian').value = '';
            document.getElementById('bank_penerima').value = '';
            document.getElementById('rek_penerima').value = '';
            document.getElementById('npwp').value = '';
            document.getElementById('jml_kotor').value = '';
            document.getElementById('potongan').value = '';
            document.getElementById('jml_bersih').value = '';
        });

        $(document).on('click', '#tarik_data', function(event) {
            event.preventDefault();
            $('#modal-overlay').modal("show");
            let urusan = $('#skpk_id').find(':selected').data('urusan');
            let bidang = $('#skpk_id').find(':selected').data('bidang');
            let unit = $('#skpk_id').find(':selected').data('unit');
            let sub = $('#skpk_id').find(':selected').data('sub');

            let href = $(this).attr('data-attr') + '?kd_urusan=' + urusan + '&kd_bidang=' + bidang + '&kd_unit=' + unit + '&kd_sub=' + sub;

            table = $('#example1').DataTable({
                destroy: true,
                processing: true,
                language: {
                    "loadingRecords": "Loading...",
                    "processing":     "Harap Menunggu, sistem sedang menghubungkan ke Server SIMDA..."
                },
                responsive: false,
                lengthChange: false,
                autoWidth: false,
                serverSide: true,
                scrollY: 500,
                scrollX: true,
                ajax: {
                    url: href,
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#modal-danger').modal("show");
                    }
                },
                columns: [
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {data: 'no_spm', name: 'no_spm'},
                    {data: 'tgl_spm', name: 'tgl_spm'},
                    {data: 'uraian', name: 'uraian'},
                    {data: 'nm_penerima', name: 'nm_penerima'},
                    {data: 'bank_penerima', name: 'bank_penerima'},
                    {data: 'rek_penerima', name: 'rek_penerima'},
                    {data: 'npwp', name: 'npwp'},
                    {data: 'jml_kotor', name: 'jml_kotor', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'potongan', name: 'potongan', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'jml_bersih', name: 'jml_bersih', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},

                ],
                columnDefs: [
                    {
                        targets: 3,
                        render: function ( data, type, row ) {
                            return data.length > 100 ?
                                data.substr( 0, 100 ) +'…' :
                                data;
                        }
                    },
                    {
                        targets: [5,6,7],
                        visible: false,
                    }
                ]
            });

        });

        $('#example1').on( 'click', 'tbody .pilih-btn', function () {
            var data = table.row( $(this).parents('tr') ).data();
            document.getElementById('no_spm').value = data.no_spm;
            $('#tgl_spm').datetimepicker('date', moment(data.tgl_spm, 'DD-MM-YYYY'));
            document.getElementById('uraian').value = data.uraian;
            document.getElementById('nm_penerima').value = data.nm_penerima;
            document.getElementById('bank_penerima').value = data.bank_penerima;
            document.getElementById('rek_penerima').value = data.rek_penerima;
            document.getElementById('npwp').value = data.npwp;
            document.getElementById('jml_kotor').value = formatNumber(data.jml_kotor);
            document.getElementById('potongan').value = formatNumber(data.potongan);
            document.getElementById('jml_bersih').value = formatNumber(data.jml_bersih);

            let no_spm_ = data.no_spm.split('/');
            let jenis_spm = no_spm_[2];
            if(jenis_spm == 'LS.BJ'){
                let lowercase = data.uraian.toLowerCase();
                if(lowercase.indexOf('perencanaan') !== -1){
                    jenis_spm = 'LS.BJ-Perencanaan';
                }else if(lowercase.indexOf('pengawasan') !== -1){
                    jenis_spm = 'LS.BJ-Pengawasan';
                }
            }

            try {
                $("input[name=jenis_spm][value='" + jenis_spm + "']").prop('checked', true);
            } catch (error) {
                alert("Format Penomoran SPM Tidak Sesuai Standar");
            }
            $('#modal-overlay').modal("hide");
        });

        let rupiah = Intl.NumberFormat('id');
        function formatNumber(num) {
            return rupiah.format(num);
        }

    </script>
@endpush
