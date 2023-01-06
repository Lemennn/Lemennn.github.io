<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'categories_id',
        'description',
        'price_from',
        'price_to',
    ];

    public function category() {
       return $this->belongsTo(ProductCategory::class , 'categories_id' , 'id');
    }

    public function galleries(){
        return $this->hasMany(ProductGallery::class, 'products_id' , 'id');
    }
}
