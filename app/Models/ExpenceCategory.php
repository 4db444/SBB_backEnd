<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Expence;

class ExpenceCategory extends Model
{
    protected $fillable = [
        "name"
    ];

    public function expences () {
        return $this->hasMany(Expence::class);
    }
}
