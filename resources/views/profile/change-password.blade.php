@extends('adminlte::page')

@section('title', 'Ubah Kata Sandi')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Tambah Agenda</h1> --}}
@stop

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="card card-primary card-outline">
                <div class="card-header bg-primary">
                    Ubah Kata Sandi
                </div>
                <div class="card-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('profile.change-password') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="current-password" class="col-sm-4 col-form-label text-sm-right">Current Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control @error('current-password') is-invalid @enderror" 
                                        id="current-password" name="current-password"
                                        value="{{ old('current-password') }}" required>
                                    @error('current-password')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new-password" class="col-sm-4 col-form-label text-sm-right">New Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control @error('new-password') is-invalid @enderror" 
                                        id="new-password" name="new-password" 
                                        value="{{ old('new-password') }}" required>
                                    @error('new-password')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new-password-confirm" class="col-sm-4 col-form-label text-sm-right">Confirm Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control @error('new-password_confirmation') is-invalid @enderror" 
                                        id="new-password-confirm" name="new-password_confirmation"
                                        value="{{ old('new-password_confirmation') }}" required>
                                    @error('new-password_confirmation')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-sm-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop