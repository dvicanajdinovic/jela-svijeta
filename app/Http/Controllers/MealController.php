<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Models\MealTranslation;
use Illuminate\Support\Facades\App;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Support\Carbon;
use App\Models\Tag;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();

        $tags = $request->tags;
        $tags_array = explode(",", $tags);

        $categories = $request->categories;
        $categories_array = explode(",", $categories);

        $ingredients = $request->ingredients;
        $ingredients_array = explode(",", $ingredients);

        $pagination = $request->pagination;

        $language = $request->language;

        $unix_timestamp = Carbon::createFromTimestamp($request->unix_timestamp)->format('m/d/Y');

        $meals = Meal::join('meal_translations', 'meals.id', 'meal_translations.meal_id')
                ->join('categories', 'meals.category_id', 'categories.id')->join('category_translations', 'categories.id', 'category_translations.category_id')
                ->where(function ($q) use ($categories_array) {
                    foreach ($categories_array as $c) {
                        $q->orWhere('category_translations.title', 'like', "%{$c}%");
                    }
                })->join('meal_ingredients', 'meals.id', 'meal_ingredients.meal_id')
                ->join('ingredients', 'ingredients.id', 'meal_ingredients.ingredient_id')
                ->where(function ($r) use ($ingredients_array) {
                    foreach ($ingredients_array as $i) {
                        $r->whereHas('ingredients', function ($r) use($i) {
                            $r->join('ingredient_translations', 'ingredient_translations.ingredient_id', 'ingredients.id')
                            ->where('ingredient_translations.title', $i);
                        });
                    }
                })->join('meal_tags', 'meals.id', 'meal_tags.meal_id')
                ->join('tags', 'tags.id', 'meal_tags.tag_id')
                ->where(function ($s) use ($tags_array) {
                    foreach ($tags_array as $t) {
                        $s->whereHas('tags', function ($s) use($t) {
                            $s->join('tag_translations', 'tag_translations.tag_id', 'tags.id')
                            ->where('tag_translations.title', $t);
                        });
                    }
                })->where(function ($t) use($unix_timestamp) {
                    $t->where('meals.created_at', '>=', $unix_timestamp)
                        ->orWhere('meals.updated_at', '>=', $unix_timestamp);
                })->where('meal_translations.locale', $language)
                ->select('meals.id', 'meal_translations.title', 'meal_translations.description', 'meals.category_id', 'meals.created_at', 'meals.updated_at')
                ->groupBy('meals.id', 'meal_translations.title', 'meal_translations.description', 'meals.category_id', 'meals.created_at', 'meals.updated_at')
                ->paginate($pagination);

        App::setLocale($language);

        return view('meals')->with(['meals'=>$meals,'next_query'=>$data, 'language'=>$language]);
    }

    public function findCategory($id)
    {
        $meal = Meal::find($id);

        $category = $meal->category;

        //dd($category);
    }

    public function findIngredients($id)
    {
        $meal = Meal::find($id);

        $ingredients = $meal->ingredients;

        //dd($ingredients);
    }

    public function findTags($id)
    {
        $meal = Meal::find($id);

        $tags = $meal->tags;

        //dd($tags);
    }

}
