<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tkp extends Model
{
    protected $guarded = ['id'];

    public function session():HasMany
    {
      return $this->hasMany(TkpSession::class, 'id_tkp', 'id');
    }
}
