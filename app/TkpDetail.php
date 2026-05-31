<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TkpDetail extends Model
{
    protected $fillable = [
      "id_tkp",
      "no_soal",
      "soal",
      "gambar_soal",
      "jawaban_a",
      "jawaban_b",
      "jawaban_c",
      "jawaban_d",
      "jawaban_e",
      "gambar_a",
      "gambar_b",
      "gambar_c",
      "gambar_d",
      "gambar_e",
      "score_a",
      "score_b",
      "score_c",
      "score_d",
      "score_e",
      "is_active",
    ];
}
