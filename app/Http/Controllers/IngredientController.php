<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Meal;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function findMeals()
    {
        //pronadji u kojem se jelu sastojak id=1 koristi
        $ingredient = Ingredient::find(1);

        $meals = $ingredient->meals;

        //dd($meals);
    }
}
