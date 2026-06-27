<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TkpSession extends Model
{
    protected $fillable = [
      "id_tkp",
      "id_user"
        
    ];

    public function tkp():BelongsTo
    {
      return $this->belongsTo(Tkp::class, 'id_tkp', 'id');
    }

    public function user():BelongsTo
    {
      return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function answer():HasMany
    {
      return $this->hasMany(TkpAnswer::class, 'id_session', 'id');
    }
}
