@extends('layouts.main')
@section('title', 'Edit User')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                                </button>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit User {{ $user->name }}</h4>
                            <a href="{{ route('userAdmin.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="roles">Peran</label>
                                    <select id="roles" name="roles" class="form-control @error('roles') is-invalid @enderror">
                                        <option value="admin" {{ $user->roles == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="dosen" {{ $user->roles == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                        <option value="kaprodi" {{ $user->roles == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                                        <option value="mahasiswa" {{ $user->roles == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    </select>
                                    @error('roles')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="permissions">Permissions</label>
                                    <select name="permissions" id="permissions" class="form-control">
                                        <option value="all" {{ $user->permissions == 'all' ? 'selected' : '' }}>All</option>
                                        <option value="view-only" {{ $user->permissions == 'view-only' ? 'selected' : '' }}>View Only</option>
                                        <option value="edit" {{ $user->permissions == 'edit' ? 'selected' : '' }}>Edit</option>
                                        <option value="delete" {{ $user->permissions == 'delete' ? 'selected' : '' }}>Delete</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
