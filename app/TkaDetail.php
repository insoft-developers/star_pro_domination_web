<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TkaDetail extends Model
{
    protected $guarded = ['id'];


    public function detailAnswer():HasMany
    {
        return $this->hasMany(TkaDetailAnswer::class, 'tka_detail_id', 'id');
    }
}
