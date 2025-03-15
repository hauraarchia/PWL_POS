<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::create([
            'username' => 'manager11',
            'nama' => 'Manager11',
            'password' => Hash::make('12345'),
            'level_id' => 2,
        ]);

        $user->username = 'manager12';
        $user->save();

        $user->wasChanged(); // true  
        $user->wasChanged('username'); // true  
        $user->wasChanged('nama'); // false  
        $user->wasChanged('nama', 'username'); // true  
        dd($user->wasChanged(['nama', 'username']));

        // $user = UserModel::create([
        //     'username' => 'manager55',
        //     'nama' => 'Manager55',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username = 'manager56';

        // $user->isDirty(); // true  
        // $user->isDirty('username'); // true  
        // $user->isDirty('nama'); // false  
        // $user->isDirty(['nama', 'username']); // true  

        // $user->isClean(); // false  
        // $user->isClean('username'); // false  
        // $user->isClean('nama'); // true  
        // $user->isClean(['nama', 'username']); // false  

        // $user->save();

        // $user->isDirty(); // false  
        // $user->isClean(); // true 
        // dd($user -> isDirty());


        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // $user -> save();
        // return view('user', ['data' => $user]);


        // $user = UserModel::where('level_id', 2)->count();
        // // dd($user);
        // return view('user', ['data' => $user]);

        // $user = UserModel::findOrFail(1);
        // return view('user', ['data' => $user]);


        // $user = UserModel::findOr(20, ['username', 'nama'], function(){
        //     abort(404);
        // });
        // return view('user',['data' => $user]);

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
