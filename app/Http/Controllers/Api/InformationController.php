<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\InformationRequest;
use App\Http\Resources\InformationResource;
use App\Models\Information;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    public function store(InformationRequest $request, Information $information)
    {
        $user = $request->user();
        $information->user_id = $user->id;
        $information->sex = $request->sex;
        $information->height = $request->height;
        $information->age = $request->age;
        $information->weight = $request->weight;
        $information->complication = $request->complication;
        $information->profession = $request->profession;
        $information->sports = $request->sports;
        $user->information()->save($information);
        return new InformationResource($information);
    }

    public function update(InformationRequest $request, Information $information)
    {
        $user = $request->user();
        
        $attributes = $request->only([
            'sex', 'height', 'age', 'weight', 'complication', 'profession', 'sports'
        ]);

        $user->information()->update($attributes);

        return new InformationResource($user->information()->get());
    }

    public function show()
    {
        $user = Auth::user();

        return new InformationResource($user->information()->get());
    }
}
