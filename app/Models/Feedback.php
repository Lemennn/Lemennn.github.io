<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'users_id', 'review'
    ];
    
    public function user(){
        return $this->hasOne(User::class, 'id', 'users_id');
    }
}
