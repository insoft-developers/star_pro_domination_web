<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TryOut extends Model
{
    protected $table = 'try_outs';
    protected $fillable = ['judul', 'short_name', 'id_kelas', 'is_active', 'is_repeated', 'is_skipped', 'time_limit', 'target_score','warna_soal','warna_tulisan','warna_jawaban','warna_tulisan_jawaban'];
    
}
