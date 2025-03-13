<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    
    protected $table = 'm_user'; //mendefinisikan nama table yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; //mendefinisikan primary key dari table yang digunakan
    
}
