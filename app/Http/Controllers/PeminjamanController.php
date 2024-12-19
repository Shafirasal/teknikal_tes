<?php
namespace App\Http\Controllers;

use App\Models\JenisKendaraanModel;
use App\Models\KendaraanModel;
use App\Models\PeminjamanModel;
use App\Models\PerusahaanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanController extends Controller
{
    // Menampilkan halaman utama peminjaman
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Peminjaman Kendaraan',
            'list'  => ['Home', 'Peminjaman']
        ];

        $page = (object)[
            'title' => 'Daftar Peminjaman Kendaraan'
        ];

        $activeMenu = 'peminjaman';

        return view('peminjaman.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // Mengambil data untuk DataTables yang asli
    // public function list(Request $request) 
    // { 
    //     $peminjaman = PeminjamanModel::with(['driver', 'koordinator', 'kendaraan', 'perusahaan'])
    //         ->select('id_peminjaman', 'id_kendaraan', 'id_perusahaan', 
    //                  'nama_peminjaman', 'tujuan_peminjaman', 
    //                  'tanggal_peminjaman', 'tanggal_berakhir_peminjaman', 'status');

    //     return DataTables::of($peminjaman) 
    //         ->addIndexColumn()  
    //         ->addColumn('driver', fn($p) => $p->driver->nama ?? '-')
    //         ->addColumn('koordinator', fn($p) => $p->koordinator->nama ?? '-')
    //         ->addColumn('aksi', function ($peminjaman) { 
    //             $btn = '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
    //             $btn .= '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
    //             $btn .= '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
    //             return $btn; 
    //         })
    //         ->rawColumns(['aksi'])  
    //         ->make(true); 
    // } 

//     public function list(Request $request) 
// { 
//     $peminjaman = PeminjamanModel::with([
//         'driver' => function ($query) {
//             $query->where('id_level', 2); // Relasi ke driver dengan level_id = 2
//         },
//         'koordinator' => function ($query) {
//             $query->where('id_level', 3); // Relasi ke koordinator dengan level_id = 3
//         },
//         'kendaraan',
//         'perusahaan'
//     ])->select(
//         'id_peminjaman',
//         'id_kendaraan',
//         'id_perusahaan',
//         'nama_peminjaman',
//         'tujuan_peminjaman',
//         'tanggal_peminjaman',
//         'tanggal_berakhir_peminjaman',
//         'status'
//     );

//     return DataTables::of($peminjaman) 
//         ->addIndexColumn()  
//         ->addColumn('driver', function ($p) {
//             return $p->driver->nama ?? '-';
//         })
//         ->addColumn('koordinator', function ($p) {
//             return $p->koordinator->nama ?? '-';
//         })
//         ->addColumn('aksi', function ($peminjaman) { 
//             $btn = '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
//             $btn .= '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
//             $btn .= '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
//             return $btn; 
//         })
//         ->rawColumns(['aksi'])  
//         ->make(true); 
// } 

public function list(Request $request)

{
    $user = Auth::user();
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User tidak terautentikasi.'
        ], 401);
    }
    $peminjaman = PeminjamanModel::with(['driver', 'koordinator', 'kendaraan', 'perusahaan'])
        ->select('id_peminjaman', 'id_kendaraan', 'id_perusahaan', 'driver_id', 'koordinator_id', 'nama_peminjaman', 'tujuan_peminjaman', 'tanggal_peminjaman', 'tanggal_berakhir_peminjaman', 'status');

    return DataTables::of($peminjaman)
        ->addIndexColumn()
        ->addColumn('driver', function ($p) {
            return $p->driver ? $p->driver->nama : '-';
        })
        ->addColumn('koordinator', function ($p) {
            return $p->koordinator ? $p->koordinator->nama : '-';
        })
        ->addColumn('aksi', function ($peminjaman) {
            $btn = '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/peminjaman/' . $peminjaman->id_peminjaman . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}

    // Menampilkan form create yang asli
    // public function create()
    // {
    //     $kendaraan = KendaraanModel::select('id_kendaraan', 'nama_kendaraan')->get();
    //     $perusahaan = PerusahaanModel::select('id_perusahaan', 'nama_perusahaan')->get();
    //     $jenisKendaraan = JenisKendaraanModel::select('id_jenis_kendaraan', 'nama_jenis_kendaraan')->get();
    //     $drivers = UserModel::select('user_id', 'nama')
    //     ->where('id_level', '=', 2)->get();
    //     $koordinators =  UserModel::select('user_id', 'nama')
    //     ->where('id_level', '=', 3)->get();



    //     return view('peminjaman.create')->with([
    //         'kendaraan' => $kendaraan,
    //         'perusahaan' => $perusahaan,
    //         'jenisKendaraan' => $jenisKendaraan,
    //         'drivers' => $drivers,
    //         'koordinators' => $koordinators,
    //     ]);
    // }


    public function create()
{
    // Ambil data kendaraan, perusahaan, driver, dan koordinator dari database
    $kendaraan = KendaraanModel::select('id_kendaraan', 'nama_kendaraan')->get();
    $perusahaan = PerusahaanModel::select('id_perusahaan', 'nama_perusahaan')->get();
    $jenisKendaraan = JenisKendaraanModel::select('id_jenis_kendaraan', 'nama_jenis_kendaraan')->get();
    $drivers = UserModel::where('id_level', 2)->select('user_id', 'nama')->get(); // Driver dengan level_id 2
    $koordinators = UserModel::where('id_level', 3)->select('user_id', 'nama')->get(); // Koordinator dengan level_id 3

    return view('peminjaman.create', [
        'kendaraan' => $kendaraan,
        'perusahaan' => $perusahaan,
        'drivers' => $drivers,
        'koordinators' => $koordinators,
        'jenisKendaraan' => $jenisKendaraan
    ]);
}


    // // Menyimpan data peminjaman yg asli
    // public function store(Request $request)
    // {
    //     $rules = [
    //         'id_kendaraan' => 'required|integer|exists:kendaraan,id_kendaraan',
    //         'id_perusahaan' => 'required|integer|exists:perusahaan,id_perusahaan',
    //         'id_jenis_kendaraan' => 'required|integer|exists:jenis_kendaraan,id_jenis_kendaraan',
    //         'driver_id' => 'required|exists:users,user_id',
    //         'koordinator_id' => 'required|exists:users,user_id',
    //         'nama_peminjaman' => 'required|string|min:3',
    //         'tujuan_peminjaman' => 'required|string',
    //         'tanggal_peminjaman' => 'required|date',
    //         'tanggal_berakhir_peminjaman' => 'required|date|after_or_equal:tanggal_peminjaman',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validasi gagal!',
    //             'msgField' => $validator->errors()
    //         ]);
    //     }

    //     // Simpan data
    //     PeminjamanModel::create([
    //         'id_kendaraan' => $request->id_kendaraan,
    //         'id_perusahaan' => $request->id_perusahaan,
    //         'id_jenis_kendaraan' => $request->id_jenis_kendaraan,
    //         'user_id' => $request->driver_id, // Driver
    //         'nama_peminjaman' => $request->nama_peminjaman,
    //         'tujuan_peminjaman' => $request->tujuan_peminjaman,
    //         'tanggal_peminjaman' => $request->tanggal_peminjaman,
    //         'tanggal_berakhir_peminjaman' => $request->tanggal_berakhir_peminjaman,
    //         'status' => 'menunggu'
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Data peminjaman berhasil disimpan.'
    //     ]);
    // }

    // public function getUsers(Request $request)
    // {
    //     $level = $request->input('level');
    
    //     // Ambil user berdasarkan id_level
    //     $users = UserModel::where('id_level', $level)->select('user_id', 'nama')->get();
    
    //     if ($users->isNotEmpty()) {
    //         return response()->json(['status' => true, 'data' => $users]);
    //     } else {
    //         return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
    //     }
    // }
    

//     public function getUsers(Request $request)
// {
//     $id_level = $request->get('id_level');

//     if (!$id_level) {
//         return response()->json([
//             'status' => false,
//             'message' => 'ID level tidak ditemukan.'
//         ], 400);
//     }

//     $users = UserModel::where('id_level', $id_level)
//         ->select('user_id', 'nama')
//         ->get();

//     return response()->json([
//         'status' => true,
//         'data' => $users
//     ]);
// }

public function store(Request $request)
{
    // Validasi input
    $rules = [
        'id_kendaraan' => 'required|integer|exists:kendaraan,id_kendaraan',
        'id_perusahaan' => 'required|integer|exists:perusahaan,id_perusahaan',
        'id_jenis_kendaraan' => 'required|integer|exists:jenis_kendaraan,id_jenis_kendaraan', 
        'driver_id' => 'required|integer|exists:users,user_id', // Validasi driver harus ada di tabel users
        'koordinator_id' => 'required|integer|exists:users,user_id', // Validasi koordinator harus ada di tabel users
        'nama_peminjaman' => 'required|string|max:100',
        'tujuan_peminjaman' => 'required|string|max:500',
        'tanggal_peminjaman' => 'required|date|after_or_equal:today',
        'tanggal_berakhir_peminjaman' => 'required|date|after:tanggal_peminjaman',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi gagal!',
            'msgField' => $validator->errors()
        ]);
    }

    // Periksa apakah driver dan koordinator memiliki level yang benar
    $driver = UserModel::where('user_id', $request->driver_id)->where('id_level', 2)->first();
    if (!$driver) {
        return response()->json([
            'status' => false,
            'message' => 'Driver yang dipilih tidak valid atau tidak memiliki level sebagai driver.'
        ]);
    }

    $koordinator = UserModel::where('user_id', $request->koordinator_id)->where('id_level', 3)->first();
    if (!$koordinator) {
        return response()->json([
            'status' => false,
            'message' => 'Koordinator yang dipilih tidak valid atau tidak memiliki level sebagai koordinator.'
        ]);
    }

    try {
        // Simpan data peminjaman ke database
        PeminjamanModel::create([
            'id_kendaraan' => $request->id_kendaraan,
            'id_perusahaan' => $request->id_perusahaan,
            'id_jenis_kendaraan' => $request->id_jenis_kendaraan, 
            'driver_id' => $request->driver_id,
            'koordinator_id' => $request->koordinator_id,
            'nama_peminjaman' => $request->nama_peminjaman,
            'tujuan_peminjaman' => $request->tujuan_peminjaman,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_berakhir_peminjaman' => $request->tanggal_berakhir_peminjaman,
            'status' => 'menunggu', // Status default
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data peminjaman berhasil disimpan!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
}

}
