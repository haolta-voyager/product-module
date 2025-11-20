<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\Database\Factories\ProductFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property int $category_id
 * @property-read Category $category
 */
class Product extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
