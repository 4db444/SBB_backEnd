<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Expense;

class ExpenseCategory extends Model
{
    protected $fillable = [
        "name"
    ];

    public function expenses () {
        return $this->hasMany(Expense::class);
    }

    public function parent (){
        return $this->belongsTo(ExpenseCategory::class, "id_parent_category");
    }

    public function children (){
        return $this->hasMany(ExpenseCategory::class, "id_parent_category");
    }
}
