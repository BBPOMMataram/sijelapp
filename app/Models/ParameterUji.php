<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterUji extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_parameter';
    protected $table = 'parameter_uji';

    public $timestamps = false;
    
    /**
     * Get the metodeuji that owns the ParameterUji
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function metodeuji()
    {
        return $this->belongsTo(MetodeUji::class, 'id_kode_layanan', 'id_kode_layanan');
    }
}
