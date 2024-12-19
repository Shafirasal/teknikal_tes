<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerusahaanModel; // Sesuaikan dengan model Anda
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PerusahaanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Perusahaan',
            'list'  => ['Home', 'Perusahaan']
        ];

        $page = (object) [
            'title' => 'Daftar perusahaan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'perusahaan';

        $perusahaan = PerusahaanModel::all();

        return view('perusahaan.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'perusahaan' => $perusahaan,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request) 
    { 
        $perusahaan = PerusahaanModel::select('id_perusahaan', 'kode_perusahaan', 'nama_perusahaan', 'lokasi', 'created_at', 'updated_at');

        if ($request->kode_perusahaan) {
            $perusahaan->where('kode_perusahaan', $request->kode_perusahaan);
        }

        return DataTables::of($perusahaan) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($perusahaan) { 
                $btn = '<button onclick="modalAction(\'' . url('/perusahaan/' . $perusahaan->id_perusahaan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/perusahaan/' . $perusahaan->id_perusahaan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/perusahaan/' . $perusahaan->id_perusahaan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn; 
            }) 
            ->rawColumns(['aksi'])  
            ->make(true); 
    }

    public function create()
    {
        return view('perusahaan.create');
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_perusahaan'   => 'required|string|min:3|unique:perusahaan,kode_perusahaan',
                'nama_perusahaan'   => 'required|string|max:255',
                'lokasi'            => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            PerusahaanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data perusahaan berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function show(String $id)
    {
        $perusahaan = PerusahaanModel::find($id);

        return view('perusahaan.show', ['perusahaan' => $perusahaan]);
    }

    public function edit(String $id)
    {
        $perusahaan = PerusahaanModel::find($id);

        return view('perusahaan.edit', ['perusahaan' => $perusahaan]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_perusahaan'   => 'required|string|min:3',
                'nama_perusahaan'   => 'required|string|max:255',
                'lokasi'            => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = PerusahaanModel::find($id);
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

    public function confirm(string $id) {
        $perusahaan = PerusahaanModel::find($id);
        
        return view('perusahaan.confirm', ['perusahaan' => $perusahaan]);
    }

    public function delete(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $perusahaan = PerusahaanModel::find($id);
            if ($perusahaan) {
                $perusahaan->delete();
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
