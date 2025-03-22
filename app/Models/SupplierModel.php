<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierModel extends Model
{
    use HasFactory;
    protected $table = 'm_supplier'; //mendefinisikan nama table yang digunakan oleh model ini
    protected $primaryKey = 'supplier_id'; //mendefinisikan primary key dari table yang digunakan

    protected $fillable = ['supplier_kode', 'supplier_nama', 'supplier_alamat'];
    
    public function stok(): HasMany
    {
        return $this->hasMany(StokModel::class);
    }
}
