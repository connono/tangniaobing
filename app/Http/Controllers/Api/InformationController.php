<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\InformationRequest;
use App\Http\Resources\InformationResource;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function store(InformationRequest $request, Information $information)
    {
        $user = $request->user();
        $information->user_id = $user->id;
        $information->phoneNumber = $request->phoneNumber;
        $information->sex = $request->sex;
        $information->height = $request->height;
        $information->age = $request->age;
        $information->weight = $request->weight;
        $information->complication = $request->complication;
        $information->profession = $request->profession;
        $information->sports = $request->sports;
        $information->bg = $request->bg;
        $information->save();
        return new InformationResource($information);
    }
}
