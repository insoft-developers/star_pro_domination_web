<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TkpSession extends Model
{
    protected $fillable = [
      "id_tkp",
      "id_user"
        
    ];
}
