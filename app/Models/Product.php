<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;
use App\Models\Review;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id',

    ];
    public function details()
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id', 'product_id');
    }
    public function image()
    {
        return $this->morphOne('APP\Models\Image', 'imagable');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}