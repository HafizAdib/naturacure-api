<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'url',
        'type',
    ];

    public function remede()
    {
        return $this->belongsTo(Remede::class);
    }

    
}
