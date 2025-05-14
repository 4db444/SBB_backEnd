<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Income;

class IncomeCategory extends Model
{
    protected $fillable = [
        "name"
    ];

    public function incomes (){
        return $this->hasMany(Income::class);
    }
}
