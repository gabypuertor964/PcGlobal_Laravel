<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipos_pqrs extends Model
{
    use HasFactory;

    //Desactivacion Campos update_at y create_at
    public $timestamps=false;
}