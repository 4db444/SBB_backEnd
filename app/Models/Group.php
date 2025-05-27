<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Expense;

class Group extends Model
{
    protected $fillable = [
        "name"
    ];

    public function members (){
        return $this->belongsToMany(User::class, "group_members");
    }

    public function expenses (){
        return $this->hasMany(Expense::class);
    }
}
