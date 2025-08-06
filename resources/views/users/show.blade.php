@extends('layouts.layout')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Detail Pengguna</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Peran</th>
                            <td>{{ $user->role ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Terdaftar</th>
                            <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td>{{ $user->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
