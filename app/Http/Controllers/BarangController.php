<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    // menampilkan halaman awal barang
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];
        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'barang'; //set menu yang sedang aktif

        $kategori = KategoriModel::all(); //ambil data kategori untuk filter kategori id
        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

//     // Ambil data barang dalam bentuk json untuk datatables
//     public function list(Request $request)
//     {
//         $barang = barangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id')
//             ->with('kategori');

//         // filter data barang brdasarkan kategori_id
//         if ($request->kategori_id) {
//             $barang->where('kategori_id', $request->kategori_id);
//         }

//         return DataTables::of($barang)
//             // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
//             ->addIndexColumn()
//             ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
//                 $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
//                 $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
//                 $btn .= '<form class="d-inline-block" method="POST" action="' .
//                     url('/barang/' . $barang->barang_id) . '">'
//                     . csrf_field() . method_field('DELETE') .
//                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return
// confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
//                 return $btn;
//             })
//             ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
//             ->make(true);
//     }
    // Menampilkan halaman form tambah barang  
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah barang',
            'list' => ['Home', 'Barang', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah Barang baru',
        ];

        $kategori = KategoriModel::all(); // ambil data kateg$kategori untuk ditampilkan di form  
        $activeMenu = 'barang'; // set menu yang sedang aktif  

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    // Menyimpan data barang baru  
    public function store(Request $request)
    {
        $request->validate([
           
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100', // barang_nama harus diisi, berupa string, dan maksimal 100 karakter  
            'harga_beli' => 'required|integer', // harga_beli harus diisi dan berupa angka  
            'harga_jual' => 'required|integer', // harga_jual harus diisi dan berupa angka  
            'kategori_id' => 'required|integer' // kategori_id harus diisi dan berupa angka  
        ]);

        barangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id
            // 'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan  
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }
    //menampilkan detail barang
    public function show(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);
        $breadcrumb = (object)[
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail Barang'
        ];
        $activeMenu = 'barang'; //set menu yang sedang aktif
        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
    // Menampilkan halaman form edit barang  
    public function edit(string $id)
    {
        $barang = barangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Barang'
        ];

        $activeMenu = 'barang'; // set menu yang sedang aktif  

        return view('barang.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'barang' => $barang,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data barang  
    public function update(Request $request, string $id)
    {
        $request->validate([
            // barangname harus diisi, berupa string, minimal 3 karakter,  
            // dan bernilai unik di tabel m_barang kolom barangname kecuali untuk barang dengan id yang sedang diedit  
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100', // barang_nama harus diisi, berupa string, dan maksimal 100 karakter  
            'harga_beli' => 'required|integer', // harga_beli harus diisi dan berupa angka  
            'harga_jual' => 'required|integer', // harga_jual harus diisi dan berupa angka  
            'kategori_id' => 'required|integer' // kategori_id harus diisi dan berupa angka  
        ]);

        BarangModel::find($id)->update([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }
    // menghapus data barang
    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if (!$check) { //untuk mengecek apakah data barang dengan id yang sedang dihapus ada atau tidak
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id); //hapus data level
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // jobsheet 6
    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.create_ajax')
            ->with('kategori', $kategori);
    }

    public function store_ajax(Request $request)
    {
        //cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
                'barang_nama' => 'required|string|max:100',
                'harga_beli' => 'required|integer', // harga_beli harus diisi dan berupa angka  
                'harga_jual' => 'required|integer' /// harga_jual harus diisi dan berupa angka    
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
            BarangModel::create(
                [
                    'kategori_id' => $request->kategori_id,
                    'barang_kode' => $request->barang_kode,
                    'barang_nama' => $request->barang_nama,
                    'harga_beli' => $request->harga_beli,
                    'harga_jual' => $request->harga_jual,
                ]
            );
            return response()->json([
                'status' => true, //response status, false: error/gagal, true: berhasil
                'message' => 'Data Barang Berhasil Disimpan',
            ]);
        }
        redirect('/');
    }

    // Ambil data barang dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $barangs = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id')
            ->with('kategori');

        // filter data barang brdasarkan kategori_id
        if ($request->kategori_id) {
            $barangs->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($barangs)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                //                 $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                //                 $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                //                 $btn .= '<form class="d-inline-block" method="POST" action="' .
                //                     url('/barang/' . $barang->barang_id) . '">'
                //                     . csrf_field() . method_field('DELETE') .
                //                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return
                // confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                $btn  = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama' => 'required|string|max:100',
                'harga_beli' => 'required|integer', // harga_beli harus diisi dan berupa angka  
                'harga_jual' => 'required|integer' /// harga_jual harus diisi dan berupa angka    
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

            $check = BarangModel::find($id);
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
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
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
