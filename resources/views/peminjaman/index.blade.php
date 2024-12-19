{{-- @extends('layouts.template')

@section('title')
    | Peminjaman Kendaraan
@endsection

@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Peminjaman Kendaraan</h3>
            <div class="card-tools">
                <button onclick="modalAction(`{{ url('/peminjaman/create') }}`)" class="btn btn-success"
                    style="background-color: #EF5428; border-color: #EF5428;">
                    <i class="fas fa-plus"></i> Tambah Peminjaman
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table responsive table-bordered table-striped table-hover table-sm" id="table_peminjaman">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kendaraan</th>
                        <th>Nama Pengguna</th>
                        <th>Nama Perusahaan</th>
                        <th>Tujuan Peminjaman</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Berakhir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .card.card-outline.card-primary {
            border-color: #375E97 !important;
        }

        .table {
            width: 100% !important;
        }
    </style>
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataPeminjaman;
        $(document).ready(function() {
            dataPeminjaman = $('#table_peminjaman').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('peminjaman/list') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", width: "4%", orderable: false, searchable: false },
                    { data: "kendaraan.nama_kendaraan", width: "12%", orderable: true },
                    { data: "user.nama", width: "12%", orderable: true },
                    { data: "perusahaan.nama_perusahaan", width: "15%", orderable: true },
                    { data: "tujuan_peminjaman", width: "20%", orderable: false },
                    { data: "tanggal_peminjaman", width: "10%", orderable: true },
                    { data: "tanggal_berakhir_peminjaman", width: "10%", orderable: true },
                    {
                        data: "status",
                        render: function(data, type, row) {
                            let badgeClass = '';
                            if (data === 'menunggu') badgeClass = 'bg-warning';
                            else if (data === 'setuju') badgeClass = 'bg-success';
                            else badgeClass = 'bg-danger';
                            return `<span class="badge ${badgeClass}">${data}</span>`;
                        },
                        className: "text-center", width: "8%"
                    },
                    { data: "aksi", className: "text-center", width: "10%", orderable: false, searchable: false }
                ],
                responsive: true,
                order: [[5, 'asc']]
            });
        });
    </script>
@endpush --}}


@extends('layouts.template')

@section('title')
    | Peminjaman Kendaraan
@endsection

@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Peminjaman Kendaraan</h3>
            <div class="card-tools">
                <button onclick="modalAction(`{{ url('/peminjaman/create') }}`)" class="btn btn-success"
                    style="background-color: #EF5428; border-color: #EF5428;">
                    <i class="fas fa-plus"></i> Tambah Peminjaman
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table responsive table-bordered table-striped table-hover table-sm" id="table_peminjaman">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kendaraan</th>
                        <th>Driver</th>
                        <th>Koordinator</th>
                        <th>Nama Perusahaan</th>
                        <th>Tujuan Peminjaman</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Berakhir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .card.card-outline.card-primary {
            border-color: #375E97 !important;
        }

        .table {
            width: 100% !important;
        }
    </style>
@endpush

@push('js')
    {{-- <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataPeminjaman;
        $(document).ready(function() {
            dataPeminjaman = $('#table_peminjaman').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('peminjaman/list') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", width: "4%", orderable: false, searchable: false },
                    { data: "kendaraan.nama_kendaraan", width: "12%", orderable: true },
                    { data: "driver", orderable: true }, // Sesuaikan dengan nama addColumn
                    { data: "koordinator", orderable: true },// Koordinator relasi dari users
                    { data: "perusahaan.nama_perusahaan", width: "15%", orderable: true },
                    { data: "tujuan_peminjaman", width: "20%", orderable: false },
                    { data: "tanggal_peminjaman", width: "10%", orderable: true },
                    { data: "tanggal_berakhir_peminjaman", width: "10%", orderable: true },
                    {
                        data: "status",
                        render: function(data, type, row) {
                            let badgeClass = '';
                            if (data === 'menunggu') badgeClass = 'bg-warning';
                            else if (data === 'setuju') badgeClass = 'bg-success';
                            else badgeClass = 'bg-danger';
                            return `<span class="badge ${badgeClass}">${data}</span>`;
                        },
                        className: "text-center", width: "8%"
                    },
                    { data: "aksi", className: "text-center", width: "10%", orderable: false, searchable: false }
                ],
                responsive: true,
                order: [[6, 'asc']]
            });
        });
    </script> --}}

    <script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataPeminjaman;
    $(document).ready(function() {
        dataPeminjaman = $('#table_peminjaman').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('peminjaman/list') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", width: "4%", orderable: false, searchable: false },
                { data: "kendaraan.nama_kendaraan", width: "12%", orderable: true },
                { data: "driver", orderable: true }, // Sesuaikan dengan nama addColumn
                { data: "koordinator", orderable: true }, // Koordinator relasi dari users
                { data: "perusahaan.nama_perusahaan", width: "15%", orderable: true },
                { data: "tujuan_peminjaman", width: "20%", orderable: false },
                { data: "tanggal_peminjaman", width: "10%", orderable: true },
                { data: "tanggal_berakhir_peminjaman", width: "10%", orderable: true },
                {
                    data: "status",
                    render: function(data) {
                        let badgeClass = '';
                        let badgeText = data ? data.toLowerCase() : '';

                        // Tentukan warna berdasarkan status
                        switch (badgeText) {
                            case 'menunggu':
                                badgeClass = 'bg-warning text-dark'; // Warna kuning dengan teks hitam
                                break;
                            case 'setuju':
                                badgeClass = 'bg-success text-white'; // Warna hijau dengan teks putih
                                break;
                            case 'tolak':
                                badgeClass = 'bg-danger text-white'; // Warna merah dengan teks putih
                                break;
                            default:
                                badgeClass = 'bg-secondary text-white'; // Warna abu-abu dengan teks putih
                        }
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    },
                    className: "text-center", width: "8%"
                },
                { data: "aksi", className: "text-center", width: "10%", orderable: false, searchable: false }
            ],
            responsive: true,
            order: [[6, 'asc']]
        });
    });
</script>

@endpush
