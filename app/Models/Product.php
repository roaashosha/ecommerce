<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function color(){
        return $this->belongsTo(Color::class);
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }
}
