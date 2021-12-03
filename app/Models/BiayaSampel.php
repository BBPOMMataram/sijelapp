<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaSampel extends Model
{
    use HasFactory;

    public function parameter()
    {
        return $this->hasOne(ParameterUji::class,'id_parameter');
    }
}
