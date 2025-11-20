<?php

namespace Modules\Product\Models;

use MongoDB\Laravel\Eloquent\Model;
use Modules\Product\Enums\Rating;

class Review extends Model
{
    protected $connection = 'mongodb';
    
    protected $collection = 'reviews';

    protected $fillable = [
        'product_id',
        'author_name',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => Rating::class,
        'product_id' => 'integer',
    ];
}
