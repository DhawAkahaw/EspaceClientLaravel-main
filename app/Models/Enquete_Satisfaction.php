<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class EnqueteSatisfaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'question1',
        'question2',
        'question3',
        'question4',
        'question5',
    ];
}
