@php
    $activeMenu = $activeMenu ?? '';
@endphp

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- Brand Logo -->
<a href="{{ url('/') }}" class="brand-link">
    <img src="{{ asset('assets/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: 1; background-color: white;">
    <span class="brand-text font-weight-bold text-light">RENTHICLE</span>
</a>

<!-- Sidebar Search Form 
<div class="form-inline mt-2 mx-3">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </div>
</div> -->

<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <!-- Untuk Admin -->
            {{-- @if(Auth::user()->id_level == 1) --}}
            @if(auth()->check() && auth()->user()->id_level == 1)
                <li class="nav-header">Data Pengguna</li>
                <li class="nav-item">
                    <a href="{{ url('/level') }}" class="nav-link {{ $activeMenu == 'level' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>Level Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/user') }}" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">
                        <i class="nav-icon far fa-user"></i>
                        <p>Data Pengguna</p>
                    </a>
                </li>
@endif
                <li class="nav-header">Mengelola Peminjaman</li>
                <li class="nav-item">
                    <a href="{{ url('/peminjaman') }}" class="nav-link {{ $activeMenu == 'peminjaman' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Peminjaman</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/perusahaan') }}" class="nav-link {{ $activeMenu == 'perusahaan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>perusahaan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/kendaraan') }}" class="nav-link {{ $activeMenu == 'kendaraan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-car"></i>
                        <p>kendaraan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/jeniskendaraan') }}" class="nav-link {{ $activeMenu == 'jeniskendaraan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>jeniskendaraan</p>
                    </a>
                </li>
                {{-- @endif --}}

                <li class="nav-header">Mengelola penerimaan</li>
                <li class="nav-item">
                    <a href="{{ url('/penerimaan') }}" class="nav-link {{ $activeMenu == 'penerimaan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Penerimaan Peminjaman</p>
                    </a>
                </li>

            <!-- Untuk Pimpinan -->
            {{-- @if(Auth::user()->id_level == 2)
                <li class="nav-header">Management Permintaan</li>
                <li class="nav-item">
                    <a href="{{ url('/penerimaanpermintaan') }}" class="nav-link {{ $activeMenu == 'penerimaanpermintaan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Penerimaan Permintaan</p>
                    </a>
                </li>
            @endif --}}

        </ul>
    </nav>
</div>
