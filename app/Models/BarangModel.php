<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangModel extends Model
{
    use HasFactory;
    protected $table = 'm_barang'; //mendefinisikan nama table yang digunakan oleh model ini
    protected $primaryKey = 'barang_id'; //mendefinisikan primary key dari table yang digunakan

    // @var array

    protected $fillable = ['kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'image'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    public function image():Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/barang/' . $image),
        );
    }
}
