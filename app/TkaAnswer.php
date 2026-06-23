<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TkaAnswer extends Model
{
    protected $guarded = ['id'];

    public function details():BelongsTo
    {
        return $this->belongsTo(TkaDetail::class, 'soal_id', 'id');
    }
}
