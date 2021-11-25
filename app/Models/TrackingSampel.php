<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingSampel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_tracking';
    protected $table = 'tracking_sampel';

    public $timestamps = false;
    
    public function permintaan()
    {
        return $this->belongsTo(TerimaSampel::class, 'id_permintaan', 'id_permintaan');
    }

    public function status()
    {
        return $this->belongsTo(StatusSampel::class,'id_status_sampel','id');
    }
}
