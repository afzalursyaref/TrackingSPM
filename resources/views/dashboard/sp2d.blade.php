@extends('adminlte::page')

@section('title', 'Monitoring SP2D')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Monitoring SP2D</h1> --}}
@stop

@push('css')
    
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Monitoring SP2D</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table id="sp2dTable" class="table table-bordered table-head-fixed table-striped display nowrap">
                    <thead>
                        <tr>
                            <th>Nomor SP2D</th>
                            <th>Nomor SPM</th>
                            <th>Keterangan</th>
                            <th>Jml Kotor</th>
                            <th>Potongan</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    <!-- /.card -->
    </div>
</div>
@stop

@push('js')
    <script>
        $(function () {
            var table = $('#sp2dTable').DataTable({
                animate:true,
                paging:false,
                info:false,
                filter:false,
                scrollY: 500,
                scrollX: true,
                ajax: "{{ route('admin.sp2d') }}",
                columns: [
                    {data: 'no_sp2d', name: 'no_sp2d'},
                    {data: 'no_spm', name: 'no_spm'},
                    {data: 'keterangan', name: 'keterangan'},
                    {data: 'jml_kotor', name: 'agenda.jml_kotor', visible:false, className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'potongan', name: 'agenda.potongan', visible:false, className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'jml_bersih', name: 'agenda.jml_bersih', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    
                ],
                columnDefs: [ 
                    {
                        targets: 2,
                        render: function ( data, type, row ) {
                            return data.length > 50 ?
                                data.substr( 0, 50 ) +'…' :
                                data;
                        }
                    }
                ],
            });

        });
        
    </script>
@endpush