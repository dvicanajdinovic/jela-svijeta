<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Meal extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $fillable = ['title', 'description'];
    public $translatedAttributes = ['title', 'description'];
    public $timestamps = true;

    public function category()
    {
        $this->belongsTo(Category::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredients');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'meal_tags');
    }
}
