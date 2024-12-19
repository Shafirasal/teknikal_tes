@extends('layouts.template')

@section('title')
    | Perusahaan
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction(`{{ url('/perusahaan/create') }}`)" class="btn btn-success"
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
                            <select class="form-control" id="kode_perusahaan" name="kode_perusahaan" required>
                                <option value="">- Semua -</option>
                                @foreach ($perusahaan as $item)
                                    <option value="{{ $item->kode_perusahaan }}">{{ $item->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table responsive table-bordered table-striped table-hover table-sm" id="table_perusahaan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Perusahaan</th>
                        <th>Nama Perusahaan</th>
                        <th>Lokasi</th>
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

        var dataPerusahaan;
        $(document).ready(function() {
            dataPerusahaan = $('#table_perusahaan').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('perusahaan/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.kode_perusahaan = $('#kode_perusahaan').val(); // Filter berdasarkan pilihan dropdown
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
                        data: "kode_perusahaan",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_perusahaan",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "lokasi",
                        orderable: true,
                        searchable: true
                    },
                ]
            });

            // Reload DataTable saat filter berubah
            $('#kode_perusahaan').on('change', function() {
                dataPerusahaan.ajax.reload();
            });
        });
    </script>
@endpush
