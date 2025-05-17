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

    public function parent(){
        return $this->belongsTo(IncomeCategory::class, "id_parent_category");
    }

    public function children (){
        return $this->hasMany(IncomeCategory::class, "id_parent_category");
    }
}
