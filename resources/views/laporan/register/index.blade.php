@extends('adminlte::page')

@section('title', 'Register Agenda')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Agenda</h1> --}}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Register Agenda</h3>
                </div>
                <div class="card-body">
                    <form id="form" action="{{ route('laporan.register.cetak') }}" method="POST" >
                        @csrf
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2">
                                <label class="col-form-label">Periode :</label>
                            </div>
                            <div class="p-2">
                                <div class="input-group date" id="tgl_start" data-target-input="nearest">
                                    <input type="text" class="form-control @error('tgl_start') is-invalid @enderror
                                        datetimepicker-input" name="tgl_start" id="input_tgl_start" data-target="#tgl_start" value="{{ old('tgl_start') }}" required/>
                                    <div class="input-group-append" data-target="#tgl_start" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('tgl_start')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="p-2">
                                <div class="input-group date" id="tgl_end" data-target-input="nearest">
                                    <input type="text" class="form-control @error('tgl_end') is-invalid @enderror
                                        datetimepicker-input" name="tgl_end" id="input_tgl_end" data-target="#tgl_end" value="{{ old('tgl_end') }}" required/>
                                    <div class="input-group-append" data-target="#tgl_end" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('tgl_end')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="p-2">
                                <button class="btn btn-secondary" id="cari">Tampilkan</button>
                                <button class="btn btn-primary" id="cetak">Cetak</button>
                            </div>
                        </div>
                    </form>

                    <table id="laporanRegister" class="table table-bordered table-striped display nowrap">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tgl Agenda</th>
                                <th>SKPK</th>
                                <th>No SPM</th>
                                <th>Tgl SPM</th>
                                <th>Uraian</th>
                                <th>Vendor/Pemkas</th>
                                <th>Jml Kotor</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(function () {
            var date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var firstDay = new Date(y, m, 1);
            var lastDay = new Date(y, m + 1, 0);

            $('#tgl_start').datetimepicker({
                format : 'DD-MM-YYYY',
                defaultDate : firstDay
            });

            $('#tgl_end').datetimepicker({
                format: 'DD-MM-YYYY',
                defaultDate : date
            });

            var table = $('#laporanRegister').DataTable({
                processing: true,
                responsive: false,
                autoWidth: false,
                serverSide: true,
                scrollY: 500,
                scrollX: true,
                ajax: {
                    url : "{{ route('laporan.register') }}",
                    data : function(d){
                        d.tgl_start = $('#input_tgl_start').val();
                        d.tgl_end = $('#input_tgl_end').val();
                    },
                    cache: false,
                },
                order: [[ 0, "asc" ]],
                columns: [
                    {data: 'nomor', name: 'agenda.nomor'},
                    {data: 'tgl_agenda', name: 'agenda.tgl_agenda'},
                    {data: 'nm_skpk', name: 'skpk.nm_skpk'},
                    {data: 'no_spm', name: 'agenda.no_spm'},
                    {data: 'tgl_spm', name: 'agenda.tgl_spm'},
                    {data: 'uraian', name: 'agenda.uraian'},
                    {data: 'nm_penerima', name: 'agenda.nm_penerima'},
                    {data: 'jml_kotor', name: 'agenda.jml_kotor', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                ],
                columnDefs: [
                    {
                        targets: 5,
                        render: function ( data, type, row ) {
                            return data.length > 100 ?
                                data.substr( 0, 100 ) +'…' :
                                data;
                        }
                    }
                ],
                select: {
                    style : 'multi'
                },
            });

            document.getElementById("cari").addEventListener("click", function(event){
                event.preventDefault();
                table.draw();
            });

            document.getElementById("cetak").addEventListener("click", function(event){
                event.preventDefault();
                var tgl_start = $('#input_tgl_start').val();
                var tgl_end = $('#input_tgl_end').val();
                var url = "{{ route('laporan.register.cetak') }}?tgl_start="+tgl_start+"&tgl_end="+tgl_end;
                window.open(url, "_blank");
            });
        });

    </script>
@endpush
