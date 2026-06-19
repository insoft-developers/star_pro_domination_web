<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tka extends Model
{
    protected $guarded = ['id'];


    public function tkaKelas():HasMany
    {
        return $this->hasMany(TkaKelasId::class, 'tka_id', 'id');
    }

    public function details():HasMany
    {
        return $this->hasMany(TkaDetail::class, 'tka_id', 'id');
    }
}
