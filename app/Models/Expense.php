<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ExpenseCategory;
use App\Models\Group;

class Expense extends Model
{
    protected $fillable = [
        "amount", 
        "description"
    ];

    public function category (){
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function group () {
        return $this->belongsTo(Group::class);
    }

    public function user (){
        return $this->belongsTo(User::class);
    }
}
