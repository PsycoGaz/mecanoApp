<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceDetachee extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prix', 'qtestock'];

    
}

