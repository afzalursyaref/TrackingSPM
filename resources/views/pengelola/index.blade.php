@extends('adminlte::page')

@section('title', 'Berkas Pada Pengelola')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Agenda</h1> --}}
@stop

@push('css')
    <style>
        .red {
            background-color: red !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('pengelola.index') }}">Berkas Pada Pengelola</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengelola.list') }}" >List</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <button type="button" name="mark" id="mark" class="btn btn-info mb-2">Tandai Berkas Sudah di Teruskan</button>

                    <table id="pengelolaTable" class="table table-bordered table-striped display nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Aksi</th>
                                <th>Nomor</th>
                                <th>Tgl Agenda</th>
                                <th>Catatan Kasi</th>
                                <th>SKPK</th>
                                <th>No SPM</th>
                                <th>Tgl SPM</th>
                                <th>Uraian</th>
                                <th>Jml Kotor</th>
                                <th>Potongan</th>
                                <th>Jml Bersih</th>
                                <th>Disposisi</th>
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
            var table = $('#pengelolaTable').DataTable({
                processing: true,
                responsive: false, 
                serverSide: true,
                scrollY: 500,
                scrollX: true,
                ajax: "{{ route('pengelola.index') }}",
                order:[[2, 'asc']],
                columns: [
                    {
                        data: 'checkbox', 
                        orderable: false, 
                        searchable: false
                    },
                    {
                        data: 'actions', 
                        name: 'actions', 
                        orderable: false, 
                        searchable: false
                    },
                    {data: 'nomor', name: 'agenda.nomor'},
                    {data: 'tgl_agenda', name: 'agenda.tgl_agenda'},
                    {data: 'catatan', name: 'verifikasi.catatan'},
                    {data: 'nm_skpk', name: 'skpk.nm_skpk'},
                    {data: 'no_spm', name: 'agenda.no_spm'},
                    {data: 'tgl_spm', name: 'agenda.tgl_spm'},
                    {data: 'uraian', name: 'agenda.uraian'},
                    {data: 'jml_kotor', name: 'agenda.jml_kotor', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'potongan', name: 'agenda.potongan', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'jml_bersih', name: 'agenda.jml_bersih', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'name', name: 'users.name'},

                    
                ],
                columnDefs: [ 
                    {
                        targets: 0,
                        checkboxes: {
                            selectRow: true
                        },
                    },
                    {
                        targets: [8],
                        render: function ( data, type, row ) {
                            return data.length > 100 ?
                                data.substr( 0, 100 ) +'…' :
                                data;
                        }
                    }
                ],
                select: {
                    style : 'multi'
                }
            });

            $('body').on('click', '.deleteVerifikasi', function(){
                var verifikasiId = $(this).data("id");
                var result = confirm("Jika Data ini dihapus, maka data akan kembali ke bagian Front Office. lanjutkan?");
                var url = "{{ route('verifikasi.destroy', ':id') }}";
                url = url.replace(':id', verifikasiId );
                if(result){
                    // alert(url);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: url ,
                        success: function (data) {
                            // console.log(data.success);
                            success_message(data.success);
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }else{
                    return false;
                }
            });

            $(document).on('click', '#mark', function(){
                var id = [];
                var markUrl = "{{ route('pengelola.mark') }}";

                $('.id_checkbox:checked').each(function(){
                    id.push($(this).val());
                });

                if(id.length > 0){
                    if(confirm("Apakah Anda Yakin ingin Menandai Bahwa Berkas Sudah Diteruskan?")){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "PUT",
                            url: markUrl,
                            data: {id:id},
                            success: function (data) {
                                // console.log(data.success);
                                success_message(data.success);
                                table.draw();
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });                  
                    }
                }else{
                    error_message('Pilih Data Terlebih Dahulu');
                }
                
            });

        });

        

    </script>
@endpush