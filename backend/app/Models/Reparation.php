<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reparation extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'cout', 'voiture_id', 'technicien_id', 'km'];

    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

    public function technicien()
    {
        return $this->belongsTo(Employe::class, 'technicien_id');
    }

    // Relation pour plusieurs pièces
    public function pieces()
    {
        return $this->belongsToMany(PieceDetachee::class, 'reparation_piece', 'reparation_id', 'piece_id');
    }
}