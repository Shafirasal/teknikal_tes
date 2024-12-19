<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KendaraanModel;
use App\Models\JenisKendaraanModel; // Model untuk jenis kendaraan
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Kendaraan',
            'list'  => ['Home', 'Kendaraan']
        ];

        $page = (object) [
            'title' => 'Daftar kendaraan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kendaraan';

        // Ambil data jenis kendaraan untuk filter
        $jenis_kendaraan = JenisKendaraanModel::all();

        return view('kendaraan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'jenis_kendaraan' => $jenis_kendaraan, // Kirim ke view
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $kendaraan = KendaraanModel::with('jenisKendaraan') // Relasi ke jenis kendaraan
            ->select(
                'id_kendaraan',
                'id_jenis_kendaraan',
                'nama_kendaraan',
                'no_kendaraan',
                'tanggal_produksi_kendaraan',
                'status'
            );

        if ($request->id_jenis_kendaraan) {
            $kendaraan->where('id_jenis_kendaraan', $request->id_jenis_kendaraan);
        }

        return DataTables::of($kendaraan)
            ->addIndexColumn()
            ->addColumn('jenis_kendaraan', function ($kendaraan) {
                return $kendaraan->jenisKendaraan->nama_jenis_kendaraan ?? '-';
            })
            ->addColumn('aksi', function ($kendaraan) {
                $btn = '<button onclick="modalAction(\'' . url('/kendaraan/' . $kendaraan->id_kendaraan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kendaraan/' . $kendaraan->id_kendaraan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kendaraan/' . $kendaraan->id_kendaraan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $jenis_kendaraan = JenisKendaraanModel::all(); // Ambil data jenis kendaraan
        return view('kendaraan.create', ['jenis_kendaraan' => $jenis_kendaraan]);
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_jenis_kendaraan' => 'required|integer',
                'nama_kendaraan' => 'required|string|max:100',
                'no_kendaraan' => 'required|string|max:20|unique:kendaraan,no_kendaraan',
                'tanggal_produksi_kendaraan' => 'required|date',
                'status' => 'required|in:tersedia,dalam pemakaian,diservice'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            KendaraanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data kendaraan berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function show(String $id)
    {
        $kendaraan = KendaraanModel::with('jenisKendaraan')->find($id);

        return view('kendaraan.show', ['kendaraan' => $kendaraan]);
    }

    public function edit(String $id)
    {
        $kendaraan = KendaraanModel::with('jenisKendaraan')->find($id);
        $jenis_kendaraan = JenisKendaraanModel::all();

        return view('kendaraan.edit', [
            'kendaraan' => $kendaraan,
            'jenis_kendaraan' => $jenis_kendaraan
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_jenis_kendaraan' => 'required|integer',
                'nama_kendaraan' => 'required|string|max:100',
                'no_kendaraan' => 'required|string|max:20',
                'tanggal_produksi_kendaraan' => 'required|date',
                'status' => 'required|in:tersedia,dalam pemakaian,diservice'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = KendaraanModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm(string $id)
    {
        $kendaraan = KendaraanModel::find($id);

        return view('kendaraan.confirm', ['kendaraan' => $kendaraan]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kendaraan = KendaraanModel::find($id);
            if ($kendaraan) {
                $kendaraan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\KendaraanModel; // Sesuaikan dengan model kendaraan Anda
// use Yajra\DataTables\Facades\DataTables;
// use Illuminate\Support\Facades\Validator;

// class KendaraanController extends Controller
// {
//     public function index()
//     {
//         $breadcrumb = (object) [
//             'title' => 'Data Kendaraan',
//             'list'  => ['Home', 'Kendaraan']
//         ];

//         $page = (object) [
//             'title' => 'Daftar kendaraan yang terdaftar dalam sistem'
//         ];

//         $activeMenu = 'kendaraan';

//         $kendaraan = KendaraanModel::all();

//         return view('kendaraan.index', [
//             'breadcrumb' => $breadcrumb, 
//             'page' => $page, 
//             'kendaraan' => $kendaraan,
//             'activeMenu' => $activeMenu
//         ]);
//     }

//     public function list(Request $request) 
//     { 
//         $kendaraan = KendaraanModel::select('id_kendaraan', 'id_jenis_kendaraan', 'nama_kendaraan', 'no_kendaraan', 'tanggal_produksi_kendaraan', 'status', 'created_at', 'updated_at');

//         if ($request->id_jenis_kendaraan) {
//             $kendaraan->where('id_jenis_kendaraan', $request->id_jenis_kendaraan);
//         }

//         return DataTables::of($kendaraan) 
//             ->addIndexColumn()  
//             ->addColumn('aksi', function ($kendaraan) { 
//                 $btn = '<button onclick="modalAction(\'' . url('/kendaraan/' . $kendaraan->id_kendaraan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/kendaraan/' . $kendaraan->id_kendaraan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
//                 $btn .= '<button onclick="modalAction(\'' . url('/kendaraan/' . $kendaraan->id_kendaraan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
//                 return $btn; 
//             }) 
//             ->rawColumns(['aksi'])  
//             ->make(true); 
//     }

//     public function create()
//     {
//         return view('kendaraan.create');
//     }

//     public function store(Request $request)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'id_jenis_kendaraan'      => 'required|integer',
//                 'nama_kendaraan'          => 'required|string|max:100',
//                 'no_kendaraan'            => 'required|string|max:20|unique:kendaraan,no_kendaraan',
//                 'tanggal_produksi_kendaraan' => 'required|date',
//                 'status'                  => 'required|in:tersedia,dalam pemakaian,diservice'
//             ];

//             $validator = Validator::make($request->all(), $rules);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validasi Gagal',
//                     'msgField' => $validator->errors(),
//                 ]);
//             }

//             KendaraanModel::create($request->all());
//             return response()->json([
//                 'status' => true,
//                 'message' => 'Data kendaraan berhasil disimpan'
//             ]);
//         }
//         return redirect('/');
//     }

//     public function show(String $id)
//     {
//         $kendaraan = KendaraanModel::find($id);

//         return view('kendaraan.show', ['kendaraan' => $kendaraan]);
//     }

//     public function edit(String $id)
//     {
//         $kendaraan = KendaraanModel::find($id);

//         return view('kendaraan.edit', ['kendaraan' => $kendaraan]);
//     }

//     public function update(Request $request, $id)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'id_jenis_kendaraan'      => 'required|integer',
//                 'nama_kendaraan'          => 'required|string|max:100',
//                 'no_kendaraan'            => 'required|string|max:20',
//                 'tanggal_produksi_kendaraan' => 'required|date',
//                 'status'                  => 'required|in:tersedia,dalam pemakaian,diservice'
//             ];

//             $validator = Validator::make($request->all(), $rules);
//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validasi gagal.',
//                     'msgField' => $validator->errors()
//                 ]);
//             }

//             $check = KendaraanModel::find($id);
//             if ($check) {
//                 $check->update($request->all());
//                 return response()->json([
//                     'status' => true,
//                     'message' => 'Data berhasil diupdate'
//                 ]);
//             } else {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Data tidak ditemukan'
//                 ]);
//             }
//         }
//         return redirect('/');
//     }

//     public function confirm(string $id) {
//         $kendaraan = KendaraanModel::find($id);
        
//         return view('kendaraan.confirm', ['kendaraan' => $kendaraan]);
//     }

//     public function delete(Request $request, $id) {
//         if ($request->ajax() || $request->wantsJson()) {
//             $kendaraan = KendaraanModel::find($id);
//             if ($kendaraan) {
//                 $kendaraan->delete();
//                 return response()->json([
//                     'status'    => true,
//                     'message'   => 'Data berhasil dihapus'
//                 ]);
//             } else {
//                 return response()->json([
//                     'status'    => false,
//                     'message'   => 'Data tidak ditemukan'
//                 ]);
//             }
//         }
//         return redirect('/');
//     }
// }
