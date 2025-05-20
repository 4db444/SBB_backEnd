<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Income extends Model
{
    use HasUlids;

    protected $fillable = [
        "amount", "description"
    ];

    public function user (){
        return $this->belongsTo(User::class);
    }

    public function category (){
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }
}
