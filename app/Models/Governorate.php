<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at','id'];
    public function addresses(){
        return $this->hasMany(Address::class);
    }
}
