<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $fillable = [
        'contenu',
        'user_id',
        'remede_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function remede()
    {
        return $this->belongsTo(Remede::class);
    }
}
