<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'Conract reference',
        'Description',
        'Starting date',
        'State',
        'Client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'cont_id');
    }
}
