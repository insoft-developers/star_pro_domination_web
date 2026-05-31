<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tkp extends Model
{
    protected $fillable = [
      "judul",
      "id_kelas",
      "is_active",
      "is_repeated",
      "is_skipped",
      "time_limit",
      "target_score",
      "warna_soal",
      "warna_tulisan",
      "short_name",
      "warna_jawaban",
      "warna_tulisan_jawaban",
    ];
}
