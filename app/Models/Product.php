<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Translatable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'store_id',
        'image',
        'status',
        'compare_price',
        'rating',
    ];

    public function getTranslatableAttributes(): array
    {
        return ['name', 'description'];
    }

    public function translatedName(?string $locale = null): string
    {
        return $this->getTranslation('name', $locale) ?? $this->name;
    }

    public function translatedDescription(?string $locale = null): string
    {
        return $this->getTranslation('description', $locale) ?? $this->description;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
