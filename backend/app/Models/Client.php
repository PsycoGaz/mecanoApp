<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'prenom', 'email','mdp'];

    public function voitures()
    {
        return $this->hasMany(Voiture::class);
    }
}
