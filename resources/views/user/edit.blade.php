@extends('adminlte::page')

@section('title', 'Pengguna')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Tambah Agenda</h1> --}}
@stop

@section('content')
    <div class="row">
        <div class="col-sm-9">
            <div class="card">
                <div class="card-header bg-primary">
                    Form Ubah Pengguna
                </div>
                <div class="card-body">

                    <form id="form" action="{{ route('user.update', $user->id) }}" method="POST" >
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="name">Nama</label>
                                    <input id="name" name="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') ?? $user->name }}" required>
                                    @error('name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="email">Email</label>
                                    <input id="email" name="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') ?? $user->email }}" required>
                                    @error('email')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="role">Role</label>
                                    <select id="role" name="role" class="custom-select">
                                        <option {{ $user->role === 'front-office' ? 'selected' : '' }} value="front-office">Front Office</option>
                                        <option {{ $user->role === 'pengelola' ? 'selected' : '' }} value="pengelola">Pengelola</option>
                                        <option {{ $user->role === 'verifikator' ? 'selected' : '' }} value="verifikator">Verifikator</option>
                                        <option {{ $user->role === 'sp2d' ? 'selected' : '' }} value="sp2d">Petugas SP2D</option>
                                        <option {{ $user->role === 'bud' ? 'selected' : '' }} value="bud">BUD</option>
                                        <option {{ $user->role === 'kuasa-bud' ? 'selected' : '' }} value="kuasa-bud">Kuasa BUD</option>
                                        <option {{ $user->role === 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                                      </select>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-sm-3 text-right">
                                <label class="col-form-label">Role :</label>
                            </div>
                            <div class="col-sm-6">
                                @foreach ($roles as $role)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                            @if ($user->hasRole($role->name))
                                                checked
                                            @endif
                                            id="role-{{ $role->name }}" value="{{ $role->name }}" name="role[]">
                                        <label class="custom-control-label" for="role-{{ $role->name }}">{{ $role->display_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <hr/>

                        <div class="form-group row">
                            <label class="col-sm-3 text-sm-right col-form-label" for="username">Username</label>
                            <div class="col-sm-6">
                                <input id="username" name="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') ?? $user->username }}" required>
                                @error('username')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 text-sm-right col-form-label" for="password">Password</label>
                            <div class="col-sm-6">
                                <input id="password" name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 text-sm-right col-form-label" for="password_confirm">Konfirmasi Password</label>
                            <div class="col-sm-6">
                                <input id="password_confirm" name="password_confirmation" type="password"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-sm-right">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
