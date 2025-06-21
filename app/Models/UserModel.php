<?php

namespace App\Models;

use Laravolt\Avatar\Avatar;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['level_id', 'username', 'avatar', 'nama', 'password', 'image'];

    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/' . $image),
        );
    }

    
    // public function getRoleName(): string
    // {
    //     return $this->level->level_nama;
    // }

    // public function hasRole($role): bool
    // {
    //     return $this->level->level_kode == $role;
    // }

    // public function getRole()
    // {
    //     return $this->level->level_kode;
    // }

    // public function getAvatarUrl(): string
    // {
    //     if ($this->avatar && file_exists(public_path($this->avatar))) {
    //         return asset($this->avatar);
    //     } else {
    //         $avatar = new Avatar();
    //         return $avatar->create($this->nama)->toBase64();
    //     }
    // }
}
