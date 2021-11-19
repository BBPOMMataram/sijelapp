<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjiProduk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_uji_produk';
    protected $table = 'uji_produk';

    public $timestamps = false;

    /**
     * Get the parameter associated with the UjiProduk
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parameter()
    {
        return $this->hasOne(ParameterUji::class,'id_parameter','id_parameter');
    }
}
