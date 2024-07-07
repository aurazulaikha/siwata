@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header"><h4>Register</h4></div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="roles">Role</label>
                            <select id="roles" class="form-control @error('roles') is-invalid @enderror" name="roles" required>
                                <option value="" disabled selected>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="dosen">Dosen</option>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="kaprodi">Kaprodi</option>
                            </select>

                            @error('roles')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" id="nip-field" style="display: none;">
                            <label for="nip">NIP</label>
                            <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}" autocomplete="nip">

                            @error('nip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" id="nidn-field" style="display: none;">
                            <label for="nidn">NIDN</label>
                            <input id="nidn" type="text" class="form-control @error('nidn') is-invalid @enderror" name="nidn" value="{{ old('nidn') }}" autocomplete="nidn">

                            @error('nidn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" id="nobp-field" style="display: none;">
                            <label for="nobp">NOBP</label>
                            <input id="nobp" type="text" class="form-control @error('nobp') is-invalid @enderror" name="nobp" value="{{ old('nobp') }}" autocomplete="nobp">

                            @error('nobp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var roles = document.getElementById('roles');
        var nipField = document.getElementById('nip-field');
        var nidnField = document.getElementById('nidn-field');
        var nobpField = document.getElementById('nobp-field');

        roles.addEventListener('change', function () {
            nipField.style.display = 'none';
            nidnField.style.display = 'none';
            nobpField.style.display = 'none';

            if (this.value === 'admin') {
                nipField.style.display = 'block';
            } else if (this.value === 'dosen' || this.value === 'kaprodi') {
                nidnField.style.display = 'block';
            } else if (this.value === 'mahasiswa') {
                nobpField.style.display = 'block';
            }
        });
    });
</script>
@endsection
