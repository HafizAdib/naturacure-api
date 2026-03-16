<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    protected $fillable = [
        'remede_id',
        'ordre',
        'description',
    ];

    public function remede()
    {
        return $this->belongsTo(Remede::class);
    }

    
}
