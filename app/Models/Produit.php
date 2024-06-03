<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_prod',
        'commercial_name',
        'reference',
        'state',
        'service_state',
        'cont_id',
    ];

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'cont_id');
    }
}
