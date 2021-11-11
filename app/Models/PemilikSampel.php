<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemilikSampel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pemilik';
    protected $table = 'pemilik_sampel';

    public $timestamps = false;
}
