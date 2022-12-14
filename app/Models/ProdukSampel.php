<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSampel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produk_sampel';
    protected $table = 'produk_sampel';

    public $timestamps = false;

    protected $dates = ['tanggal_surat'];

    /**
     * Get all of the ujiproduk for the ProdukSampel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujiproduk()
    {
        return $this->hasMany(UjiProduk::class, 'id_produk_sampel', 'id_produk_sampel');
    }

    /**
     * Get the permintaan that owns the ProdukSampel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permintaan()
    {
        return $this->belongsTo(TerimaSampel::class, 'id_permintaan', 'id_permintaan');
    }

    /**
     * Get the user that owns the ProdukSampel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'saksi_ahli', 'id');
    }
}
