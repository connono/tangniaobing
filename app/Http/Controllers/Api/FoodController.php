<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\FoodRequest;
use App\Http\Resources\FoodResource;
use App\Models\Food;

class FoodController extends Controller
{
    public function store(FoodRequest $request, Food $food)
    {
       $food->name = $request->name; 
       $food->gi = $request->gi; 
       $food->energy = $request->energy; 
       $food->carbohydrate = $request->carbohydrate; 
       $food->axunge = $request->axunge; 
       $food->protein = $request->protein;
       
       $food->save();
       return new FoodResource($food);
    }

    public function update(FoodRequest $request, Food $food)
    {
        $food = Food::find($request->id);

        $attributes = $request->only([
            'name', 'gi', 'energy', 'carbohydrate', 'axunge', 'protein'
        ]);

        $food->update($attributes);

        return new FoodResource($food);
    }

    public function delete(FoodRequest $request, Food $food)
    {
        $food = Food::find($request->id);
        $food->delete($request->id);
        return new FoodResource($food);
    }

    public function show()
    {
        return new FoodResource(Food::all());
    }
}