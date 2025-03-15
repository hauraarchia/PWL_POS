<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level'; //mendefinisikan nama table yang digunakan oleh model ini
    protected $primaryKey = 'level_id'; //mendefinisikan primary key dari table yang digunakan

    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class);
    }
}
