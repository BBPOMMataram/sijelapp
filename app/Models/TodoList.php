<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    public function getCreatedAtAttribute($value) 
    {
        $createdAt = Carbon::parse($value);
        return $createdAt->diffForHumans();
    }
}
