<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class DemandeTransfertLigne extends Model
{
    use HasFactory;

    protected $fillable = [
        'adsl_num',
        'new_num_tel',
        'state_line_prop',
        'nic',
        'current_address',
        'new_address',
        'Ticket',
        'Previous_Number',
        'State',
        'created_at',
        'Remarque',
        'client_id',
    ];


    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function produit()
    {
        return $this->hasOne(Contrat::class, 'reference', 'adsl_num');
    }
}
