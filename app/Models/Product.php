<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];

    protected $appends = ['price_float'];

    protected $casts = [
        'created_at' => 'date:d/m/Y'
    ];

    public function priceFloat(): Attribute
    {
        return new Attribute(
            get: fn($price) => $this->attributes['price'] / 100
        );
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
/*
    public function price(): Attribute
    {
        return new Attribute(
            fn($price) => $price / 100,
            fn($price) => $price * 100
        );
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format("d/m/Y");
    }
    */
}
