<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remede extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'user_id',
        'maladie_id',
        'status'
    ];

    public function maladie()
    {
        return $this->belongsTo(Maladie::class);
    }

    public function etapes()
    {
        return $this->hasMany(Etape::class)->orderBy('ordre');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
