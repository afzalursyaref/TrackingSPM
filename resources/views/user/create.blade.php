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
                    Form Pengguna
                </div>
                <div class="card-body">
                    
                    <form id="form" action="{{ route('user.store') }}" method="POST" >
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="name">Nama</label>
                                    <input id="name" name="name" type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('name') }}" required>
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
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="role">Role</label>
                                    <select id="role" name="role" class="custom-select">
                                        <option {{ (old('role') == 'front-office') ? 'selected' : '' }} value="front-office">Front Office</option>
                                        <option {{ (old('role') == 'pengelola') ? 'selected' : '' }} value="pengelola">Pengelola</option>
                                        <option {{ (old('role') == 'verifikator') ? 'selected' : '' }} value="verifikator">Verifikator</option>
                                        {{-- <option {{ (old('role') == 'sp2d') ? 'selected' : '' }} value="sp2d">Petugas SP2D</option> --}}
                                        <option {{ (old('role') == 'bud') ? 'selected' : '' }} value="bud">BUD</option>
                                        <option {{ (old('role') == 'kuasa-bud') ? 'selected' : '' }} value="kuasa-bud">Kuasa BUD</option>
                                        <option {{ (old('role') == 'admin') ? 'selected' : '' }} value="admin">Admin</option>
                                      </select>
                                </div>
                            </div>
                        </div>

                        <hr/>

                        <div class="form-group row">
                            <label class="col-sm-3 text-sm-right col-form-label" for="username">Username</label>
                            <div class="col-sm-6">
                                <input id="username" name="username" type="text" 
                                    class="form-control @error('username') is-invalid @enderror" 
                                    value="{{ old('username') }}" required>
                                @error('username')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 text-sm-right col-form-label" for="password">Password</label>
                            <div class="col-sm-6">
                                <input id="password" name="password" type="password" 
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 text-sm-right col-form-label" for="password_confirm">Konfirmasi Password</label>
                            <div class="col-sm-6">
                                <input id="password_confirm" name="password_confirmation" type="password" 
                                    class="form-control" required>
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