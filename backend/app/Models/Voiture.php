<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voiture extends Model
{
    use HasFactory;
    protected $fillable = ['marque', 'modele', 'annee', 'client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function reparations()
    {
        return $this->hasMany(Reparation::class);
    }
}

