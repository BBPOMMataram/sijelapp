<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerimaSampel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_permintaan';
    protected $table = 'permintaan';

    // public $timestamps = false;

    /**
     * Get the pemiliksampel that owns the TerimaSampel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemiliksampel()
    {
        return $this->belongsTo(PemilikSampel::class, 'id_pemilik', 'id_pemilik');
    }

    /**
     * Get the kategori that owns the TerimaSampel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
