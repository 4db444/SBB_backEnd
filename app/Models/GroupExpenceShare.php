<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupExpenceShare extends Model
{
    protected $fillable = [
        "user_id",
        "expence_id",
        "amount"
    ];
}
