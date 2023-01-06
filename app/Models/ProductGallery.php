<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductGallery extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'product_galleries';
    
    protected $fillable = [
        'url',
        'products_id'
    ];

    // public function getAttribute($url)
    // {
    //     return config('app.url').Storage::url('url');
    // }

    public function product() {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
