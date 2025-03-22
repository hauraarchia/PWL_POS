<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

        $kategories = KategoriModel::all(); //ambil data level untuk filter level
        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategories' => $kategories, 'activeMenu' => $activeMenu]);
    }

    // Ambil data kategori dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $kategories = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        // filter data user brdasarkan kategori_id
        if ($request->kategori_id) {
            $kategories->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($kategories)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategories) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/kategori/' . $kategories->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategories->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/kategori/' . $kategories->kategori_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return
confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
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

        $kategories = KategoriModel::all(); // ambil data level untuk ditampilkan di form  
        $activeMenu = 'kategori'; // set menu yang sedang aktif  

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategories' => $kategories, 'activeMenu' => $activeMenu]);
    }
    // Menyimpan data user baru  
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username  
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
    // Menampilkan halaman form edit user  
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

    // Menyimpan perubahan data user  
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter,  
            // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit  
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' .$id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100', // nama kategori harus diisi, berupa string, dan maksimal 100 karakter  
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }
    // menghapus data user
    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) { //untuk mengecek apakah data kategori dengan id yang sedang dihapus ada atau tidak
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id); //hapus data level
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
