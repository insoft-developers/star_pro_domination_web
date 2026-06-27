<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TkpAnswer extends Model
{
    protected $guarded = ['id'];

    public function details():BelongsTo
    {
        return $this->belongsTo(TkpDetail::class, 'id_soal', 'id');
    }
}
