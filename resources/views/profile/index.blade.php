@extends('adminlte::page')

@section('title', 'Profil Pengguna')

@section('content_header')
    <h1 class="m-0 text-dark">Profil Pengguna</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('css/croppie.min.css') }}">
@endpush

@section('content')

    @if (!$user->profile()->exists())
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Peringatan!</h5>
            Wajib Mengisi Biodata dan Upload Foto
        </div>
    @endif
    <div class="row">
        <div class="col-sm-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if ($user->profile()->exists())
                            @if ($user->profile->photo == null)
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('profile/avatar.png') }}"
                                    alt="{{ $user->name }}">
                            @else
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('profile/'.$user->profile->photo) }}"
                                    alt="{{ $user->name }}">
                            @endif
                        @else
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('profile/avatar.png') }}"
                                alt="{{ $user->name }}">
                        @endif
                        
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ $user->role }}</p>

                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-success">
                        Ganti Foto
                    </button>
                </div>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('profile.updateUser') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" placeholder="Nama"
                                    value="{{ old('name') ?? $user->name }}" required>
                                @error('name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" placeholder="Email"
                                    value="{{ old('email') ?? $user->email }}" required>
                                @error('email')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                    id="username" name="username" placeholder="Username"
                                    value="{{ old('username') ?? $user->username }}" required>
                                @error('username')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-danger">Simpan</button>
                            </div>
                        </div>
                    </form>

                    @php
                        if (!$user->profile()->exists()) {
                            $user->profile = new App\Models\Profile();
                            $user->profile->nip = "";
                            $user->profile->golongan = "";
                            $user->profile->jabatan = "";
                        }
                    @endphp
                    <form class="form-horizontal" method="POST" action="{{ route('profile.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                    id="nip" name="nip" placeholder="NIP"
                                    value="{{ old('nip') ?? $user->profile->nip }}" required>
                                @error('nip')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="golongan" class="col-sm-2 col-form-label">Golongan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('golongan') is-invalid @enderror" 
                                    id="golongan" name="golongan" placeholder="golongan"
                                    value="{{ old('golongan') ?? $user->profile->golongan }}" required>
                                @error('golongan')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" 
                                    id="jabatan" name="jabatan" placeholder="jabatan"
                                    value="{{ old('jabatan') ?? $user->profile->jabatan }}" required>
                                @error('jabatan')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-danger">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Foto Profil</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="upload-demo"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {{-- <label for="upload">Pilih Foto:</label> --}}
                                <div class="custom-file">
                                <input type="file" class="custom-file-input" id="upload">
                                <label class="custom-file-label" for="upload">Pilih Foto</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="">
                            <div id="upload-demo-i"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary upload-result">Upload</button>
                </div>
            </div>
        </div>
    </div>
  @stop

@push('js')
    <script src="{{ asset('js/croppie.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $uploadCrop = $('#upload-demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });


        $('#upload').on('change', function () { 
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });


        $('.upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: "{{ route('profile.upload') }}",
                    type: "POST",
                    data: {"image":resp},
                    success: function (data) {
                        location.reload();
                        // console.log(data);
                        // html = '<img src="' + resp + '" />';
                        // $("#upload-demo-i").html(html);
                    }
                });
            });
        });
    </script>
@endpush