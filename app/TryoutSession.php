<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TryoutSession extends Model
{
    protected $fillable = ['id_tryout', 'id_user'];
}
