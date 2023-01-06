<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'products_id','transactions_id','quantity','users_id'
    ];

    public function product(){
        return $this->hasOne(Product::class, 'id', 'products_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'users_id');
    }

}
