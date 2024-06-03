<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

use Laravel\Sanctum\HasApiTokens;

class Client extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'last_name',
        'rue',
        'gouvernorat',
        'delegation',
        'localite',
        'ville',
        'code_postal',
        'tel',
        'gsm',
        'login',
        'password',
        'picture',
        'code_Client',
        'type_Client',
    ];

    public function contrat()
    {
        return $this->hasOne(Contrat::class, 'Client_id');
    }

    public function demandeMigration()
    {
        return $this->hasMany(DemandeMigration::class, 'client_id');
    }
}
