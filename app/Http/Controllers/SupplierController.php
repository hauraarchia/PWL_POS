<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    // menampilkan halaman awal supplier
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];
        $page = (object) [
            'title' => 'Supplier yang terdaftar dalam sistem'
        ];
        $activeMenu = 'supplier'; //set menu yang sedang aktif

        $supplier = SupplierModel::all(); //ambil data supplier untuk filter supplier
        return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    //     // Ambil data supplier dalam bentuk json untuk datatables
    //     public function list(Request $request)
    //     {
    //         $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

    //         // filter data user brdasarkan supplier_id
    //         if ($request->supplier_id) {
    //             $supplier->where('supplier_id', $request->supplier_id);
    //         }

    //         return DataTables::of($supplier)
    //             // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
    //             ->addIndexColumn()
    //             ->addColumn('aksi', function ($supplier) { // menambahkan kolom aksi
    //                 $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //                 $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //                 $btn .= '<form class="d-inline-block" method="POST" action="' .
    //                     url('/supplier/' . $supplier->supplier_id) . '">'
    //                     . csrf_field() . method_field('DELETE') .
    //                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return
    // confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
    //             ->make(true);
    //     }
    // Menampilkan halaman form tambah supplier  
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah supplier baru',
        ];

        $supplier = SupplierModel::all(); // ambil data supplier untuk ditampilkan di form  
        $activeMenu = 'supplier'; // set menu yang sedang aktif  

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }
    // Menyimpan data user baru  
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username  
            'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode',
            'supplier_nama' => 'required|string|max:100', // nama supplier harus diisi, berupa string, dan maksimal 100 karakter  
            'supplier_alamat' => 'required|string|max:100', // alamat supplier harus diisi, berupa string, dan maksimal 100 karakter  
        ]);

        SupplierModel::create([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }
    //menampilkan detail  supplier
    public function show(string $id)
    {
        // Cari supplier berdasarkan ID
        $supplier = SupplierModel::find($id);
        // dd($id, $supplier); // Cek nilai id dan kategor
        $breadcrumb = (object)[
            'title' => 'Detail supplier',
            'list' => ['Home', 'supplier', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail supplier'
        ];
        $activeMenu = 'supplier'; //set menu yang sedang aktif
        return view('supplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }
    // Menampilkan halaman form edit supplier  
    public function edit(string $id)
    {
        $supplier = SupplierModel::find($id);
        // $supplier = SupplierModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Supplier'
        ];

        $activeMenu = 'supplier'; // set menu yang sedang aktif  

        return view('supplier.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user  
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter,  
            // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit  
            'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
            'supplier_nama' => 'required|string|max:100', // nama supplier harus diisi, berupa string, dan maksimal 100 karakter  
            'supplier_alamat' => 'required|string|max:100', // alamat supplier harus diisi, berupa string, dan maksimal 100 karakter  
        ]);

        SupplierModel::find($id)->update([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }
    // menghapus data user
    public function destroy(string $id)
    {
        $check = SupplierModel::find($id);
        if (!$check) { //untuk mengecek apakah data supplier dengan id yang sedang dihapus ada atau tidak
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            SupplierModel::destroy($id); //hapus data supplier
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // jobsheet 6
    public function create_ajax()
    {
        $supplier = SupplierModel::select('supplier_kode', 'supplier_nama', 'supplier_alamat')->get();

        return view('supplier.create_ajax')
            ->with('supplier', $supplier);
    }

    public function store_ajax(Request $request)
    {
        //cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode',
                'supplier_nama' => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:100',
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
            SupplierModel::create(
                [
                    'supplier_kode' => $request->supplier_kode,
                    'supplier_nama' => $request->supplier_nama,
                    'supplier_alamat' => $request->supplier_alamat,
                ]
            );
            return response()->json([
                'status' => true, //response status, false: error/gagal, true: berhasil
                'message' => 'Data supplier Berhasil Disimpan',
            ]);
        }
        redirect('/');
    }

    // Ambil data supplier dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        // filter data supplier brdasarkan supplier_id
        if ($request->supplier_id) {
            $supplier->where('supplier_id', $request->supplier_id);
        }
        $supplier_id = $request->input('filter_supplier');
        if (!empty($supplier_id)) {
            $supplier->where('supplier_id', $supplier_id);
        }

        return DataTables::of($supplier)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) { // menambahkan kolom aksi
                $btn  = '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        // $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode,'  . $id . ',supplier_id',
                'supplier_nama' => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:100',
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

            $check = SupplierModel::find($id);
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
        $supplier = SupplierModel::find($id);
        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
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
    public function import()
    {
        return view('supplier.import');
    }
    public function import_ajax(Request $request)
    {
        // dd($request->all());
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_supplier' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_supplier'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'supplier_kode' => $value['A'],
                            'supplier_nama' => $value['B'],
                            'supplier_alamat' => $value['C'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    SupplierModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        //ambil data supp$supplier yang akan di export

        $supplier = SupplierModel::select('supplier_kode', 'supplier_nama', 'supplier_alamat')
            ->get();

        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); //ambil sheet yang aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Supplier');
        $sheet->setCellValue('C1', 'Nama Supplier');
        $sheet->setCellValue('D1', 'Alamat Supplier');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true); //bold header

        $no = 1; //nomor dimulai dari 1
        $baris = 2;
        foreach ($supplier as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->supplier_kode);
            $sheet->setCellValue('C' . $baris, $value->supplier_nama);
            $sheet->setCellValue('D' . $baris, $value->supplier_alamat);
            $baris++;
            $no++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set autosize untuk kolom
        }

        $sheet->setTitle('Data Supplier'); // set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Supplier ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
        //end function export_excel
    }

    public function export_pdf()
    {
        $supplier = SupplierModel::select('supplier_kode', 'supplier_nama', 'supplier_alamat')
            ->orderBy('supplier_kode')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('supplier.export_pdf', ['supplier' => $supplier]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption('isRemoteEnabled', true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data Supplier ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
