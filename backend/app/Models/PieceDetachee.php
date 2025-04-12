<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceDetachee extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prix', 'reparation_id','qtestock '];

    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }
}

