<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'poste', 'salaire'];

    public function reparations()
    {
        return $this->hasMany(Reparation::class, 'technicien_id');
    }
}

