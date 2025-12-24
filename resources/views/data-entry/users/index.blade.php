@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('icon', '')

@section('actions')
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i> Tambah Pengguna
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-soft border-light-custom">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-gradient">Daftar Pengguna</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(isset($users) && $users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->email === 'admin@bpbd.com')
                                        <span class="badge bg-danger">Admin</span>
                                    @else
                                        <span class="badge bg-secondary">User</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->email !== 'admin@bpbd.com')
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus pengguna?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-users fa-4x mb-3"></i>
                    <p>Tidak ada data pengguna</p>
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Pengguna Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection