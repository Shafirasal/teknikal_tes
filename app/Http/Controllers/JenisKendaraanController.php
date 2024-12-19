<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKendaraanModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class JenisKendaraanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Jenis Kendaraan',
            'list'  => ['Home', 'Jenis Kendaraan']
        ];

        $page = (object) [
            'title' => 'Daftar jenis kendaraan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'jeniskendaraan';

        $jeniskendaraan = JenisKendaraanModel::all();

        return view('jeniskendaraan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'jeniskendaraan' => $jeniskendaraan,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $jeniskendaraan = JenisKendaraanModel::select('id_jenis_kendaraan', 'kode_jenis_kendaraan', 'nama_jenis_kendaraan');

        if ($request->id_jenis_kendaraan) {
            $jeniskendaraan->where('id_jenis_kendaraan', $request->id_jenis_kendaraan);
        }

        return DataTables::of($jeniskendaraan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($jeniskendaraan) {
                $btn = '<button onclick="modalAction(\'' . url('/jeniskendaraan/' . $jeniskendaraan->id_jenis_kendaraan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jeniskendaraan/' . $jeniskendaraan->id_jenis_kendaraan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jeniskendaraan/' . $jeniskendaraan->id_jenis_kendaraan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('jeniskendaraan.create');
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_jenis_kendaraan'   => 'required|string|min:3|unique:jenis_kendaraan,kode_jenis_kendaraan',
                'nama_jenis_kendaraan'   => 'required|string|max:50'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            JenisKendaraanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data jenis kendaraan berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function show(String $id)
    {
        $jeniskendaraan = JenisKendaraanModel::find($id);

        return view('jeniskendaraan.show', ['jeniskendaraan' => $jeniskendaraan]);
    }

    public function edit(String $id)
    {
        $jeniskendaraan = JenisKendaraanModel::find($id);

        return view('jeniskendaraan.edit', ['jeniskendaraan' => $jeniskendaraan]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_jenis_kendaraan'   => 'required|string|min:3',
                'nama_jenis_kendaraan'   => 'required|string|max:50'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = JenisKendaraanModel::find($id);
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
        $jeniskendaraan = JenisKendaraanModel::find($id);

        return view('jeniskendaraan.confirm', ['jeniskendaraan' => $jeniskendaraan]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $jeniskendaraan = JenisKendaraanModel::find($id);
            if ($jeniskendaraan) {
                $jeniskendaraan->delete();
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
