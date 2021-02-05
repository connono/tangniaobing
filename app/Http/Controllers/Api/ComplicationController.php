<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ComplicationRequest;
use App\Models\Complication;
use App\Http\Resources\ComplicationResource;

class ComplicationController extends Controller
{
    public function store(ComplicationRequest $request, Complication $complication)
    {
       $complication->name = $request->name; 
       
       $complication->save();
       return new ComplicationResource($complication);
    }

    public function update(ComplicationRequest $request, Complication $complication)
    {
        $complication = Complication::find($request->id);

        $attributes = $request->only([
            'name', 'gi', 'energy', 'carbohydrate', 'axunge', 'protein'
        ]);

        $complication->update($attributes);

        return new ComplicationResource($complication);
    }

    public function delete(ComplicationRequest $request, Complication $complication)
    {
        $complication = Complication::find($request->id);
        $complication->delete($request->id);
        return new ComplicationResource($complication);
    }

    public function show()
    {
        return new ComplicationResource(Complication::all());
    }
}
