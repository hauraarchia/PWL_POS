<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // menampilkan halaman awal kategori
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];
        $page = (object) [
            'title' => 'Kategori barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'kategori'; //set menu yang sedang aktif

        $kategories = KategoriModel::all(); //ambil data kategori untuk filter kategori
        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategories' => $kategories, 'activeMenu' => $activeMenu]);
    }

    // Ambil data kategori dalam bentuk json untuk datatables
//     public function list(Request $request)
//     {
//         $kategories = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

//         // filter data Kategori brdasarkan kategori_id
//         if ($request->kategori_id) {
//             $kategories->where('kategori_id', $request->kategori_id);
//         }

//         return DataTables::of($kategories)
//             // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
//             ->addIndexColumn()
//             ->addColumn('aksi', function ($kategories) { // menambahkan kolom aksi
//                 $btn = '<a href="' . url('/kategori/' . $kategories->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
//                 $btn .= '<a href="' . url('/kategori/' . $kategories->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
//                 $btn .= '<form class="d-inline-block" method="POST" action="' .
//                     url('/kategori/' . $kategories->kategori_id) . '">'
//                     . csrf_field() . method_field('DELETE') .
//                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return
// confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
//                 return $btn;
//             })
//             ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
//             ->make(true);
//     }
    // Menampilkan halaman form tambah kategori  
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru',
        ];

        $kategories = KategoriModel::all(); // ambil data kategori untuk ditampilkan di form  
        $activeMenu = 'kategori'; // set menu yang sedang aktif  

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategories' => $kategories, 'activeMenu' => $activeMenu]);
    }
    // Menyimpan data Kategori baru  
    public function store(Request $request)
    {
        $request->validate([
            // Kategoriname harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_Kategori kolom Kategoriname  
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100', // nama kategori harus diisi, berupa string, dan maksimal 100 karakter  
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }
    //menampilkan detail  kategori
    public function show(string $id)
    {
        // Cari kategori berdasarkan ID
        $kategories = KategoriModel::find($id);
        // dd($id, $kategories); // Cek nilai id dan kategor
        $breadcrumb = (object)[
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail Kategori'
        ];
        $activeMenu = 'kategori'; //set menu yang sedang aktif
        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategories' => $kategories, 'activeMenu' => $activeMenu]);
    }
    // Menampilkan halaman form edit Kategori  
    public function edit(string $id)
    {
        $kategories = KategoriModel::find($id);
        // $kategories = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kategori'
        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif  

        return view('kategori.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategories' => $kategories,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data Kategori  
    public function update(Request $request, string $id)
    {
        $request->validate([
            // Kategoriname harus diisi, berupa string, minimal 3 karakter,  
            // dan bernilai unik di tabel m_Kategori kolom Kategoriname kecuali untuk Kategori dengan id yang sedang diedit  
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' .$id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100', // nama kategori harus diisi, berupa string, dan maksimal 100 karakter  
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }
    // menghapus data Kategori
    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) { //untuk mengecek apakah data kategori dengan id yang sedang dihapus ada atau tidak
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id); //hapus data kategori
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // jobsheet 6
    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')->get();

        return view('kategori.create_ajax')
            ->with('kategori', $kategori);
    }

    public function store_ajax(Request $request)
    {
        //cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|string|max:100',
            ];

            // use Illiminate\Support\Facades\Validator
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, //responAse status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }
            KategoriModel::create(
                [
                    'kategori_kode' => $request->kategori_kode,
                    'kategori_nama' => $request->kategori_nama,
                ]
            );
            return response()->json([
                'status' => true, //response status, false: error/gagal, true: berhasil
                'message' => 'Data Kategori Berhasil Disimpan',
            ]);
        }
        redirect('/');
    }

    // Ambil data Kategori dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        // filter data Kategori brdasarkan kategori_id
        if ($request->kategori_id) {
            $kategori->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($kategori)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
                $btn  = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        // $kategori = kategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,'  . $id . ',kategori_id',
                'kategori_nama' => 'required|string|max:100',
            ];
            // use Illuminate\Support\Facades\Validator; 
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,    // respon json, true: berhasil, false: gagal 
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()  // menunjukkan field mana yang error 
                ]);
            }

            $check = KategoriModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
