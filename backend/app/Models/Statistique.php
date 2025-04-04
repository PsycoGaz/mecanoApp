<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistique extends Model
{
    use HasFactory;

    protected $fillable = ['nb_reparations', 'ca_total', 'top_clients'];
}

