<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; //implementasi class authenticatable

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user'; // mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // mendefinisikan primary key dari tabel yang digunakan
    //@var array;

    protected $fillable = ['level_id', 'username', 'nama', 'password'];
    // protected $fillable = ['level_id','username','nama'];

    protected $hidden = ['password']; //jangan ditampilkan saat select
    protected $casts = ['password' => 'hashed'];


    //relasi ke tabel level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    /**
     * Mengambil nama peran
     */
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    /**
     * Memeriksa apakah pengguna memiliki peran tertentu
     */
    public function hasRole($role): bool
    {
        return $this->level->level_kode === $role;
    }

    /**
     * Mengambil kode peran
     */
    public function getRole()
    {
        return $this->level->level_kode;
    }
}