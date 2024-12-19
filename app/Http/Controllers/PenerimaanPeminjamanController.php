<?php

// namespace App\Http\Controllers;

// use App\Models\PeminjamanModel;
// use Illuminate\Support\Facades\Log;
// use Yajra\DataTables\Facades\DataTables;

// class PenerimaanPeminjamanController extends Controller
// {
//     // Halaman index
//     public function index()
//     {
//         $breadcrumb = (object) [
//             'title' => 'Penerimaan Peminjaman',
//             'list'  => ['Home', 'Penerimaan Peminjaman']
//         ];

//         $page = (object) [
//             'title' => 'Daftar Penerimaan Peminjaman'
//         ];

//         $activeMenu = 'penerimaan_peminjaman';

//         return view('penerimaan.index', compact('breadcrumb', 'page', 'activeMenu'));
//     }

//     // List DataTables
//     public function list()
//     {
//         $peminjaman = PeminjamanModel::with(['driver', 'koordinator', 'kendaraan', 'perusahaan'])
//             ->select('id_peminjaman', 'id_kendaraan', 'id_perusahaan', 'driver_id', 'koordinator_id', 'nama_peminjaman', 'tujuan_peminjaman', 'tanggal_peminjaman', 'tanggal_berakhir_peminjaman', 'status');
    
//         return DataTables::of($peminjaman)
//             ->addIndexColumn()
//             ->addColumn('driver', function ($p) {
//                 return $p->driver ? $p->driver->nama : '-';
//             })
//             ->addColumn('koordinator', function ($p) {
//                 return $p->koordinator ? $p->koordinator->nama : '-';
//             })
//             ->addColumn('aksi', function ($peminjaman) {
//                 $btn = '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
//                 return $btn;
//             })
//             ->rawColumns(['aksi'])
//             ->make(true);
//     }

   
// } 




namespace App\Http\Controllers;

use App\Models\PeminjamanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PenerimaanPeminjamanController extends Controller
{
    // Halaman index
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Penerimaan Peminjaman',
            'list'  => ['Home', 'Penerimaan Peminjaman']
        ];

        $page = (object) [
            'title' => 'Daftar Penerimaan Peminjaman'
        ];

        $activeMenu = 'penerimaan_peminjaman';

        return view('penerimaan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // List DataTables dengan filter status 'menunggu'
    public function list(Request $request)
    {
        // Ambil data peminjaman dengan status "menunggu"
        $peminjaman = PeminjamanModel::with(['driver', 'koordinator', 'kendaraan', 'perusahaan'])
            ->where('status', 'menunggu') // Hanya data dengan status "menunggu"
            ->select(
                'id_peminjaman',
                'id_kendaraan',
                'id_perusahaan',
                'driver_id',
                'koordinator_id',
                'nama_peminjaman',
                'tujuan_peminjaman',
                'tanggal_peminjaman',
                'tanggal_berakhir_peminjaman',
                'status'
            );
    
        // Return data ke DataTables
        return DataTables::of($peminjaman)
            ->addIndexColumn() // Tambahkan kolom nomor urut
            ->addColumn('driver', function ($p) {
                return $p->driver ? $p->driver->nama : '-';
            })
            ->addColumn('koordinator', function ($p) {
                return $p->koordinator ? $p->koordinator->nama : '-';
            })
            ->addColumn('aksi', function ($peminjaman) {
                // Tambahkan tombol aksi untuk detail, setuju, dan tolak
                $btn = '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="setujui(' . $peminjaman->id_peminjaman . ')" class="btn btn-success btn-sm">Setujui</button> ';
                $btn .= '<button onclick="tolak(' . $peminjaman->id_peminjaman . ')" class="btn btn-danger btn-sm">Tolak</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // Pastikan kolom "aksi" tidak di-escape
            ->make(true);
    }
    
    

    // // Fungsi untuk menyetujui permintaan peminjaman
    // public function approve($id)
    // {
    //     $peminjaman = PeminjamanModel::find($id);

    //     if ($peminjaman && $peminjaman->status === 'menunggu') {
    //         $peminjaman->status = 'setuju';
    //         $peminjaman->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Peminjaman telah disetujui!'
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Data peminjaman tidak ditemukan atau sudah diproses.'
    //     ], 404);
    // }

    // // Fungsi untuk menolak permintaan peminjaman
    // public function reject($id)
    // {
    //     $peminjaman = PeminjamanModel::find($id);

    //     if ($peminjaman && $peminjaman->status === 'menunggu') {
    //         $peminjaman->status = 'tolak';
    //         $peminjaman->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Peminjaman telah ditolak!'
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Data peminjaman tidak ditemukan atau sudah diproses.'
    //     ], 404);
    // }

    public function approve($id)
{
    try {
        // Cari data peminjaman berdasarkan ID
        $peminjaman = PeminjamanModel::findOrFail($id);

        // Update status menjadi "setuju"
        $peminjaman->status = 'setuju';
        $peminjaman->save();

        return response()->json([
            'status' => true,
            'message' => 'Peminjaman berhasil disetujui.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

public function reject($id)
{
    try {
        // Cari data peminjaman berdasarkan ID
        $peminjaman = PeminjamanModel::findOrFail($id);

        // Update status menjadi "tolak"
        $peminjaman->status = 'tolak';
        $peminjaman->save();

        return response()->json([
            'status' => true,
            'message' => 'Peminjaman berhasil ditolak.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

}
