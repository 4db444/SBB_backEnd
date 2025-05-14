<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\models\Group;
use App\models\Income;

class User extends Model
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

    public function personalExpences (){
        return $this->hasMany(Expence::class);
    }

    public function sharedExpences (){
        return $this->belongsToMany(Expence::class, "group_expence_shares")
            ->withPivote("amount")
            ->withTimestamps();
    }

    public function groups (){
        return $this->belongsToMany(Group::class);
    }
}
