@extends('layouts.template')

@section('title')
    | Jenis Kendaraan
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction(`{{ url('/jeniskendaraan/create') }}`)" class="btn btn-success"
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
                            <select class="form-control" id="id_jeniskendaraan" name="id_jeniskendaraan">
                                <option value="">- Semua -</option>
                                @foreach ($jeniskendaraan as $jenis)
                                    <option value="{{ $jenis->id_jenis_kendaraan }}">{{ $jenis->nama_jenis_kendaraan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table responsive table-bordered table-striped table-hover table-sm" id="table_jeniskendaraan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Jenis</th>
                        <th>Nama Jenis Kendaraan</th>
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

        var dataJenisKendaraan;
        $(document).ready(function() {
            dataJenisKendaraan = $('#table_jeniskendaraan').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('jeniskendaraan/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.id_jeniskendaraan = $('#id_jeniskendaraan').val(); // Filter berdasarkan dropdown
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
                        data: "kode_jenis_kendaraan",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_jenis_kendaraan",
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
            $('#id_jeniskendaraan').on('change', function() {
                dataJenisKendaraan.ajax.reload();
            });
        });
    </script>
@endpush
