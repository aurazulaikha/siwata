@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <!-- Profile Header Content -->
                    </div>
                    <div class="profile-widget-description">

                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ $mahasiswa->nama }}</h5>
                                    <p>
                                        <strong>NoBP :</strong> {{ $mahasiswa->nobp }}<br>
                                        <strong>No Telp :</strong> {{ $mahasiswa->telp }}<br>
                                        <strong>Prodi :</strong> {{ $mahasiswa->prodi->nama_prodi }}<br>
                                        <strong>Alamat :</strong> {{ $mahasiswa->alamat }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
