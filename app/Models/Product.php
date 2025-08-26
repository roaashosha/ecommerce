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

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function scopeFilter($query,$filters){
        if (isset($filters['color'])){
            $query->where('color',$filters['color']);
        }

        if (isset($filters['min_price']) && isset($filters['max_price'])){
            $query->whereBetween('price',[$filters['min_price'],$filters['max_price']]);           
        }
        else if (isset($filters['min_price'])){
            $query->where('price','>=',$filters['min_price']);
        }
        else if (isset($filters['max_price'])){
            $query->where('price',"<=",$filters['max_price']);
        }

        if (isset($filters['category_id'])){
            $query->where('category_id',$filters['category_id']);
        }

        if (isset($filters['sort'])){
            if ($filters['sort']==='price_asc'){
                $query->orderBy('price','asc');
            }else if ($filters['sort']==='price_desc'){
                $query->orderBy('price','desc');
            }

        }
    return $query;
    }

    public function scopeFilterByCategoryGender($query, $categoryId = null, $gender = 'all')
    {
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($gender && $gender !== 'all') {
            $query->where('target_gender', $gender);
        }

        return $query;
    }
}
