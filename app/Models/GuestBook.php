<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class GuestBook extends Model
{
    use HasFactory;

    public function getSelfieAttribute($value)
    {
        return Storage::url($value);
    }

    /**
     * Get the service associated with the GuestBook
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function serviceType(): HasOne
    {
        return $this->hasOne(GuestService::class, 'id', 'service');
    }
}
