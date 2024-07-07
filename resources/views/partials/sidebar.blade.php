<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-3">
            <a href="l"><img src="/img/logo.png" alt="" class="img-fluid custom-logo-size"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">{{ strtoupper(substr(config('app.name'), 0, 2)) }}</a>
        </div>
        <ul class="sidebar-menu">
            @if (Auth::check() && Auth::user()->roles == 'admin')
            <li class="{{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Master Data</li>

            <li class="nav-item dropdown {{ request()->routeIs('') ? 'active' : '' }}">

                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-book"></i> <span>Data User</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('dosen.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dosen.index') }}">Dosen</a>
                    </li>
                    <li class="{{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
                    </li>
                    <li class="{{ request()->routeIs('kaprodi.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('kaprodi.index') }}">Kaprodi</a>
                    </li>
                </ul>
            </li>



            <li class="{{ request()->routeIs('prodi.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('prodi.index') }}"><i <i class="fas fa-newspaper"></i></i> <span>Prodi</span></a></li>

            <li class="{{ request()->routeIs('ruangan.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('ruangan.index') }}"><i class="far fa-building"></i> <span>Ruangan</span></a></li>

            <li class="{{ request()->routeIs('sesi.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('sesi.index') }}"><i class="far fa-building"></i> <span>Sesi</span></a></li>
            <li class="{{ request()->routeIs('user.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('userAdmin.index') }}"><i class="fas fa-user"></i> <span>User</span></a></li>
            <li class="menu-header">Sidang TA</li>
            <li class="{{ request()->routeIs('Daftar TA.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dokumenSidang.IndexForAdmin') }}"><i class="fas fa-book"></i> <span>Daftar TA</span></a></li>

            <li class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jadwalTa.IndexForAdmin') }}"><i class="fas fa-book"></i> <span>Jadwal Sidang TA</span></a></li>

            <li class="{{ request()->routeIs('nilaiTa.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('sidangTa.nilaiAdmin') }}"><i class="fas fa-book"></i> <span>Nilai Ta</span></a></li>

            <li class="{{ request()->routeIs('report.sidangAdmin') ? 'active' : '' }}"><a class="nav-link" href="{{ route('report.sidangAdmin') }}"><i class="fas fa-book"></i> <span>Report</span></a></li>


            @elseif (Auth::check() && Auth::user()->roles == 'kaprodi')
            <li class="{{ request()->routeIs('kaprodi.dashboard.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('kaprodi.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Master Data</li>
            <li class="{{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('mahasiswa.kaprodi') }}"><i class="fas fa-users"></i> <span>Mahasiswa</span></a></li>
            <li class="{{ request()->routeIs('dosen.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dosen.kaprodi') }}"><i class="fas fa-user"></i> <span>Data Dosen</span></a></li>
            <li class="{{ request()->routeIs('ruangan.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('ruangan.kaprodi') }}"><i class="far fa-building"></i> <span>Ruangan</span></a></li>
            <li class="{{ request()->routeIs('sesi.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('sesi.kaprodi') }}"><i class="far fa-building"></i> <span>Sesi</span></a></li>
            <li class="menu-header">Proposal TA</li>
            <li class="{{ request()->routeIs('proposalTa.IndexForKaprodi') ? 'active' : '' }}"><a class="nav-link" href="{{ route('proposalTa.IndexForKaprodi') }}"><i class="fas fa-book"></i> <span>Verifikasi Proposal</span></a></li>
            <li class="{{ request()->routeIs('sidang_proposal.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('sidang_proposal.index') }}"><i class="fas fa-book"></i> <span>Jadwal Sidang</span></a></li>

            <li class="menu-header">Sidang TA</li>
            <li class="{{ request()->routeIs('dokumenSidang.IndexForKaprodi') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dokumenSidang.IndexForKaprodi') }}"><i class="fas fa-book"></i> <span>Verifikasi Pendaftaran</span></a></li>
            <li class="{{ request()->routeIs('sidang_ta.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('sidang_ta.index') }}"><i class="fas fa-book"></i> <span>Jadwal Sidang TA</span></a></li>
            <li class="{{ request()->routeIs('sidangTa.nilaiKaprodi') ? 'active' : '' }}"><a class="nav-link" href="{{ route('sidangTa.nilaiKaprodi') }}"><i class="fas fa-book"></i> <span>Nilai Ta</span></a></li>
            <li class="{{ request()->routeIs('report.sidang') ? 'active' : '' }}"><a class="nav-link" href="{{ route('report.sidang') }}"><i class="fas fa-book"></i> <span>Report</span></a></li>


            @elseif (Auth::check() && Auth::user()->roles == 'dosen')
            <li class="{{ request()->routeIs('dosen.dashboard.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dosen.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Proposal TA</li>

            <li class="nav-item dropdown {{ request()->routeIs('proposal_ta.*') ? 'active' : '' }}">

                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-book"></i> <span>Verifikasi Proposal</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('proposalTa.indexForDosen1') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('proposalTa.indexForDosen1') }}">Pembimbing 1</a>
                    </li>
                    <li class="{{ request()->routeIs('proposalTa.indexForDosen2') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('proposalTa.indexForDosen2') }}">Pembimbing 2</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ request()->routeIs('jadwal') ? 'active' : '' }}">

                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-calendar"></i> <span>Jadwal Sidang </span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('jadwal.pem1') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('jadwal.pem1') }}">Sebagai Pembimbing 1</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwal.pem2') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('jadwal.pem2') }}">Sebagai Pembimbing 2</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwal.penguji') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('jadwal.penguji') }}">Sebagai Penguji</a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Sidang TA</li>


            <li class="nav-item dropdown {{ request()->routeIs('proposal_ta.*') ? 'active' : '' }}">

                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-calendar"></i> <span>Verifikasi Pendaftaran</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('dokumenSidang.indexForDosen1') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dokumenSidang.indexForDosen1') }}">Sebagai Pembimbing 1</a>
                    </li>
                    <li class="{{ request()->routeIs('dokumenSidang.indexForDosen2') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dokumenSidang.indexForDosen2') }}">Sebagai Pembimbing 2</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ request()->routeIs('proposal_ta.*') ? 'active' : '' }}">

                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-calendar"></i> <span>Jadwal Sidang TA</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('jadwalTa.ketua') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('jadwalTa.ketua') }}">Sebagai Ketua</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwalTa.sekretaris') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('jadwalTa.sekretaris') }}">Sebagai Sekretaris</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwalTa.penguji1') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('jadwalTa.penguji1') }}">Sebagai Penguji 1</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwalTa.penguji2') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('jadwalTa.penguji2') }}">Sebagai Penguji 2</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ request()->routeIs('proposal_ta.*') ? 'active' : '' }}">

                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-calendar"></i> <span>Input Nilai TA</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('jadwalTa.sekretaris') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('sidangTa.pembimbing1') }}">Sebagai Pembimbing1</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwalTa.sekretaris') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('sidangTa.pembimbing2') }}">Sebagai Pembimbing2</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwalTa.ketua') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('sidangTa.ketua') }}">Sebagai Ketua</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwalTa.sekretaris') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('sidangTa.sekretaris') }}">Sebagai Sekretaris</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwalTa.anggota1') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('sidangTa.penguji1') }}">Sebagai Penguji 1</a>
                    </li>
                    <li class="{{ request()->routeIs('jadwalTa.anggota2') ? 'active' : '' }}">
                        <a class="dropdown-item" href="{{ route('sidangTa.penguji2') }}">Sebagai Penguji 2</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('sidangTa.nilaiDosen') ? 'active' : '' }}"><a class="nav-link" href="{{ route('sidangTa.nilaiDosen') }}"><i class="fas fa-book"></i> <span>Rekap Nilai</span></a></li>




            @elseif (Auth::check() && Auth::user()->roles == 'mahasiswa')
            <li class="{{ request()->routeIs('mahasiswa.dashboard.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('mahasiswa.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
            </li>

            <li class="menu-header">Proposal TA</li>

            <li class="nav-item dropdown {{ request()->routeIs('proposal_ta.*') ? 'active' : '' }}">

                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-book"></i> <span>Proposal Ta</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('proposal_ta.pengajuan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('proposalTa.index') }}">Pengajuan Proposal</a>
                    </li>
                    <li class="{{ request()->routeIs('proposal_ta.status') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('statusProposalTa.index') }}">Status Proposal</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('proposal_ta.status') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jadwal.mahasiswa') }}"><i class="fas fa-book"></i> <span>Jadwal Sidang</span></a></li>

            <li class="menu-header">Sidang TA</li>

            <li class="{{ request()->routeIs('dokumenSidang.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dokumenSidang.index') }}"><i class="fas fa-book"></i> <span>Pendaftaran Sidang</span></a></li>

            <li class="{{ request()->routeIs('dokumenSidang.status') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dokumenSidang.status') }}"><i class="fas fa-book"></i> <span>Status Dokumen</span></a></li>

            <li class="{{ request()->routeIs('jadwalTa.mahasiswa') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jadwalTa.mahasiswa') }}"><i class="fas fa-book"></i> <span>Jadwal Sidang</span></a></li>

            <li class="{{ request()->routeIs('sidangTa.mahasiswa') ? 'active' : '' }}"><a class="nav-link" href="{{ route('sidangTa.mahasiswa') }}"><i class="fas fa-book"></i> <span>Nilai Ta</span></a></li>


            @endif

        </ul>
    </aside>
</div>


