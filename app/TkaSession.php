<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TkaSession extends Model
{
    protected $guarded = ['id'];

    public function tka():BelongsTo
    {
        return $this->belongsTo(Tka::class, 'tka_id', 'id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function answer():HasMany
    {
        return $this->hasMany(TkaAnswer::class, 'session_id', 'id');
    }
}
