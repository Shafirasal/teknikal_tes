<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Level',
            'list'  => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level';

        $level = LevelModel::all();

        return view('level.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }
    public function list(Request $request) 
    { 
        $level = LevelModel::select('id_level', 'kode_level', 'nama_level');

        if ($request->id_level){
            $level->where('id_level', $request->id_level);
        }

        return DataTables::of($level) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($level) { 
                $btn = '<button onclick="modalAction(\'' . url('/level/' . $level->id_level . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->id_level . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->id_level . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn; 
            }) 
            ->rawColumns(['aksi'])  
            ->make(true); 
    } 
   
    public function create()
    {

        return view('level.create');
    }

    // Menyimpan data level baru ajax
    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_level'   => 'required|string|min:3|unique:level,kode_level',
                'nama_level'   => 'required|string|max:25'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,  // response status , false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            LevelModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail level
    public function show(String $id)
    {
        $level = LevelModel::find($id);

        return view('level.show', ['level' => $level]);
    }

    // Menampilkan halaman form edit level
    public function edit(String $id)
    {
        $level = LevelModel::find($id);

        return view('level.edit', ['level' => $level]);
    }


    // Menyimpan perubahan data level
    public function update(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_level'   => 'required|string|min:3',
                'nama_level'   => 'required|string|max:25'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = LevelModel::find($id);
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

    // Menampilkan hapus data level ajax
    public function confirm(string $id) {
        $level = LevelModel::find($id);
        
        return view('level.confirm', ['level' => $level]);
    }

    // Menghapus data level ajax
    public function delete(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);
            if ($level) {
                $level->delete();
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}

