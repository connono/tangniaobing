<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\BloodGlucoseRequest;
use App\Http\Resources\BloodGlucoseResource;
use App\Models\BloodGlucose;
use Illuminate\Support\Facades\Auth;

class BloodGlucoseController extends Controller
{
    public function store(BloodGlucoseRequest $request, BloodGlucose $bloodGlucose)
    {
        $user = $request->user();

        $bloodGlucose->user_id = $user->id;
        $bloodGlucose->type = $request->type;
        $bloodGlucose->blood_glucose = $request->blood_glucose;

        $user->bloodGlucose()->save($bloodGlucose);

        return new BloodGlucoseResource($bloodGlucose);
    }

    public function show(BloodGlucoseRequest $request)
    {
        $user = Auth::user();
        $type = $request->type;
        return new BloodGlucoseResource($user->bloodGlucose()->where('type', $type)->get());
    }
}
