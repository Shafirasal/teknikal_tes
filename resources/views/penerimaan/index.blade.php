@extends('layouts.template')

@section('title')
    | Penerimaan Peminjaman
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $page->title }}</h3>
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
                            <th>Perusahaan</th>
                            <th>Tujuan</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
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
// $(document).ready(function () {
//     var table = $('#table_peminjaman').DataTable({
//         processing: true,
//         serverSide: true,
//         responsive: true,
//         ajax: {
//             url: "{{ url('penerimaan/list') }}",
//             type: "POST",
//             data: {
//                 _token: "{{ csrf_token() }}",
//             },
//         },
//         columns: [
//             { data: "id_peminjaman", className: "text-center", width: "4%" },
//             { data: "kendaraan.nama_kendaraan", width: "15%" },
//             { data: "driver", width: "12%" },
//             { data: "koordinator", width: "12%" },
//             { data: "perusahaan.nama_perusahaan", width: "15%" },
//             { data: "tujuan_peminjaman", width: "20%" },
//             { data: "tanggal_peminjaman", width: "10%" },
//             { data: "tanggal_berakhir_peminjaman", width: "10%" },
//             {
//                 data: "status",
//                 render: function(data) {
//                     let badgeClass = data === 'menunggu' ? 'bg-warning' : data === 'setuju' ? 'bg-success' : 'bg-danger';
//                     return `<span class="badge ${badgeClass}">${data}</span>`;
//                 },
//                 className: "text-center",
//                 width: "8%"
//             },
//             {
//                 data: "aksi",
//                 orderable: false,
//                 searchable: false,
//                 className: "text-center",
//                 width: "12%"
//             }
//         ],
//     });
//   // Fungsi untuk menyetujui peminjaman
//   window.setujui = function (id) {
//         $.ajax({
//             url: "{{ url('penerimaan') }}/" + id + "/approve",
//             type: "POST",
//             data: {
//                 _token: "{{ csrf_token() }}",
//             },
//             success: function (response) {
//                 alert(response.message);
//                 table.ajax.reload();
//             },
//             error: function (xhr) {
//                 alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
//             },
//         });
//     };

//     // Fungsi untuk menolak peminjaman
//     window.tolak = function (id) {
//         $.ajax({
//             url: "{{ url('penerimaan') }}/" + id + "/reject",
//             type: "POST",
//             data: {
//                 _token: "{{ csrf_token() }}",
//             },
//             success: function (response) {
//                 alert(response.message);
//                 table.ajax.reload();
//             },
//             error: function (xhr) {
//                 alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
//             },
//         });
//     };
// });

$(document).ready(function () {
    var table = $('#table_peminjaman').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ url('penerimaan/list') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
            },
        },
        columns: [
            { data: "id_peminjaman", className: "text-center", width: "4%" },
            { data: "kendaraan.nama_kendaraan", width: "15%" },
            { data: "driver", width: "12%" },
            { data: "koordinator", width: "12%" },
            { data: "perusahaan.nama_perusahaan", width: "15%" },
            { data: "tujuan_peminjaman", width: "20%" },
            { data: "tanggal_peminjaman", width: "10%" },
            { data: "tanggal_berakhir_peminjaman", width: "10%" },
            {
                data: "status",
                render: function(data) {
                    if (data) {
                        let badgeClass;
                        switch (data.toLowerCase()) {
                            case 'setuju':
                                badgeClass = 'bg-success text-white'; // Hijau untuk status "Setuju"
                                break;
                            case 'menunggu':
                                badgeClass = 'bg-warning text-dark'; // Kuning untuk status "Menunggu"
                                break;
                            case 'tolak':
                                badgeClass = 'bg-danger text-white'; // Merah untuk status "Tolak"
                                break;
                            default:
                                badgeClass = 'bg-secondary text-white'; // Abu-abu untuk status lain
                        }
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    }
                    return '-';
                },
                className: "text-center",
                width: "8%"
            },
            {
                data: "aksi",
                orderable: false,
                searchable: false,
                className: "text-center",
                width: "12%"
            }
        ],
    });

    // Fungsi untuk menyetujui peminjaman
    window.setujui = function (id) {
        $.ajax({
            url: "{{ url('penerimaan') }}/" + id + "/approve",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                });
                table.ajax.reload();
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: xhr.responseJSON.message || 'Gagal menyetujui peminjaman.',
                });
            },
        });
    };

    // Fungsi untuk menolak peminjaman
    window.tolak = function (id) {
        $.ajax({
            url: "{{ url('penerimaan') }}/" + id + "/reject",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                });
                table.ajax.reload();
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: xhr.responseJSON.message || 'Gagal menolak peminjaman.',
                });
            },
        });
    };
});

</script>
@endpush


