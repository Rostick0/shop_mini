<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *    schema="ProductSchema",
 *       @OA\Property(property="id", type="number", example=1),
 *       @OA\Property(property="title", type="string", example="Игрвой ноутбук 2003"),
 *       @OA\Property(property="description", type="string", example="john@test.com"),
 *       @OA\Property(property="price", type="float", example="2022-06-28 06:06:17"),
 *       @OA\Property(property="old_price", type="float", example="2022-06-28 06:06:17"),
 *       @OA\Property(property="count", type="number", example="7"),
 *       @OA\Property(property="is_infinitely", type="boolean", example="true"),
 *       @OA\Property(property="raiting", type="float", example="5"),
 *       @OA\Property(property="user_id", type="number", example=1),
 *       @OA\Property(property="category_id", type="number", example=1),
 *       @OA\Property(property="created_at", type="datetime", example="2022-06-28 06:06:17"),
 *       @OA\Property(property="updated_at", type="datetime", example="2022-06-28 06:06:17"),
 *    )
 * )
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'old_price',
        'count',
        'is_infinitely',
        'raiting',
        'user_id',
        'category_id',
    ];

    public function files(): MorphMany
    {
        return $this->morphMany(FileRelationship::class, 'file_relable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(ImageRelat::class, 'image_relatsable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product_property_item(): HasMany
    {
        return $this->hasMany(ProductPropertyItem::class);
    }
}
