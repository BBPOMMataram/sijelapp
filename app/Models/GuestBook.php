<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GuestBook extends Model
{
    use HasFactory;

    public function getSelfieAttribute($value)
    {
        return Storage::url($value);
    }
}
