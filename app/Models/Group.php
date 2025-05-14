<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Expence;

class Group extends Model
{
    protected $fillable = [
        "name"
    ];

    public function users (){
        return $this->belongsToMany(User::class);
    }

    public function expences (){
        return $this->hasMany(Expence::class);
    }
}
