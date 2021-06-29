@extends('adminlte::page')

@section('title', 'Pengguna')

@section('content_header')
    <h1 class="m-0 text-dark">Pengguna</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('user.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>

                    <table id="userTable" class="table table-bordered table-striped display nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
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
            var table = $('#userTable').DataTable({
                processing: true,
                responsive: true, 
                serverSide: true,
                ajax: "{{ route('user.index') }}",
                columns: [
                    {   
                        data: null,
                        orderable: false, 
                        searchable: false, 
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'username', name: 'username'},
                    {data: 'role', name: 'role'},
                    {
                        data: 'actions', 
                        name: 'actions', 
                        orderable: false, 
                        searchable: false
                    },
                ]
            });

            $('body').on('click', '.deleteUser', function(){
                var userId = $(this).data("id");
                var result = confirm("Apakah Anda Yakin ingin menghapus data ini?");
                var url = "{{ route('user.destroy', ':id') }}";
                url = url.replace(':id', userId );
                if(result){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: url ,
                        success: function (data) {
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
            })
        });

        

    </script>
@endpush