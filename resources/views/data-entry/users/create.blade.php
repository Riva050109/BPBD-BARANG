@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('icon', '')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-soft border-light-custom">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-gradient">Form Tambah Pengguna</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
    @csrf
    
    <div class="mb-3">
        <label for="name" class="form-label">Nama *</label>
        <input type="text" name="name" id="name" class="form-control" 
               value="{{ old('name') }}" required autofocus>
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email *</label>
        <input type="email" name="email" id="email" class="form-control" 
               value="{{ old('email') }}" required>
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password *</label>
        <input type="password" name="password" id="password" class="form-control" 
               minlength="8" required autocomplete="new-password">
        <small class="text-muted">Minimal 8 karakter</small>
        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password *</label>
        <input type="password" name="password_confirmation" id="password_confirmation" 
               class="form-control" required autocomplete="new-password">
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role *</label>
        <select name="role" id="role" class="form-control" required>
            <option value="">Pilih Role</option>
            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        @error('role')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</form>
            </div>
        </div>
    </div>
</div>
@endsection