<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

// class Client extends Model
// {
//     use HasFactory;
//     protected $fillable = ['nom', 'prenom', 'email','mdp','role'];

//     public function voitures()
//     {
//         return $this->hasMany(Voiture::class);
//     }
// }


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'email', 'mdp', 'role'];

    // Relation avec les voitures
    public function voitures()
    {
        return $this->hasMany(Voiture::class);
    }

    // Méthode pour obtenir l'identifiant JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Méthode pour personnaliser les réclamations JWT
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function getAuthPassword()
    {
        return $this->mdp;
    }

//     public function setMdpAttribute($value)
// {
//     $this->attributes['mdp'] = bcrypt($value);
// }
}