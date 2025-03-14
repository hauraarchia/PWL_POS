<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $user = UserModel::where('username', 'manager9')->firstOrFail();
        return view('user', ['data' => $user]);
        
        // $user = UserModel::findOrFail(1);
        // return view('user', ['data' => $user]);
        
        
        // $user = UserModel::findOr(20, ['username', 'nama'], function(){
        //     abort(404);
        // });
        // return view('user',['data' => $user]);
=======
        $user = UserModel::findOr(20, ['username', 'nama'], function(){
            abort(404);
        });
        return view('user',['data' => $user]);
>>>>>>> dc1b34a6b9942efb073e038e9aaeb0dc6bfc1e03
        
        // $user = UserModel::firstWhere('level_id', 1);
        // return view('user', ['data' => $user]);

        //tambah data user dengan eloquent model
        // $data = [
        //     // 'level_id' => 2,
        //     // 'username' => 'manager_data',
        //     // 'nama' => 'Manager 2',
        //     // 'password' => Hash::make('12345')

        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // // coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);
    }
}
