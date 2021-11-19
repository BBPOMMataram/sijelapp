<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodeUji extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kode_layanan';
    protected $table = 'kode_layanan';

    public $timestamps = false;
}
