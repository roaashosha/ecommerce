<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = ['created_at','updated_at','id'];

    public function country(){
    return $this->belongsTo(Country::class);
}

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function governorate(){
        return $this->belongsTo(Governorate::class);
    }

    public function zipcode(){
        return $this->belongsTo(Zipcode::class);
    }


}
