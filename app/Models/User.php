<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use App\Models\Group;
use App\Models\Income;

class User extends Authenticable
{
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "password",
        "profile"
    ];

    protected $hidden = [
        "password"
    ];

    public function incomes () {
        return $this->hasMany(Income::class);
    }

    public function expenses (){
        return $this->hasMany(Expense::class);
    }

    public function groupExpenseShares (){
        return $this->belongsToMany(Expense::class, "group_expense_shares")
            ->withPivote("amount")
            ->withTimestamps();
    }

    public function groups (){
        return $this->belongsToMany(Group::class);
    }
}
