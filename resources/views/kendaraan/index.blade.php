@extends('layouts.template')

@section('title')
    | Kendaraan
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction(`{{ url('/kendaraan/create') }}`)" class="btn btn-success"
                    style="background-color: #EF5428; border-color: #EF5428;"> <i class="fas fa-plus"> </i> Tambah</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }} </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }} </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter: </label>
                        <div class="col-3">
                            <select class="form-control" id="id_jenis_kendaraan" name="id_jenis_kendaraan" required>
                                <option value="">- Semua Jenis -</option>
                                @foreach ($jenis_kendaraan as $jenis)
                                    <option value="{{ $jenis->id_jenis_kendaraan }}">{{ $jenis->nama_jenis_kendaraan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table responsive table-bordered table-striped table-hover table-sm" id="table_kendaraan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kendaraan</th>
                        <th>Nomor Kendaraan</th>
                        <th>Tanggal Produksi</th>
                        <th>jenis Kendaraan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
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

        var dataKendaraan;
        $(document).ready(function() {
            dataKendaraan = $('#table_kendaraan').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('kendaraan/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.id_jenis_kendaraan = $('#id_jenis_kendaraan').val(); // Filter berdasarkan jenis kendaraan
                    }
                },
                columns: [
    {
        data: "DT_RowIndex",
        className: "text-center",
        orderable: false,
        searchable: false
    },
    {
        data: "nama_kendaraan",
        orderable: true,
        searchable: true
    },
    {
        data: "no_kendaraan",
        orderable: true,
        searchable: true
    },
    {
        data: "tanggal_produksi_kendaraan",
        orderable: true,
        searchable: false
    },
    {
        data: "jenis_kendaraan", // Menggunakan nama kolom "jenis_kendaraan"
        orderable: true,
        searchable: true
    },
    {
        data: "aksi",
        orderable: false,
        searchable: false,
        className: "text-center"
    }
]

            });

            // Reload DataTable saat filter berubah
            $('#id_jenis_kendaraan').on('change', function() {
                dataKendaraan.ajax.reload();
            });
        });
    </script>
@endpush
