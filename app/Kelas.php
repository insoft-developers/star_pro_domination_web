<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = "kelas";
    protected $fillable =['nama_kelas'];
    
    
    public function user() {
        return $this->hasMany('App\User', 'id_kelas');
    }
}
