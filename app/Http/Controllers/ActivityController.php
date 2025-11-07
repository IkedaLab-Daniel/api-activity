<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Activity::query();

        if ($request->has('status')){
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status'=> 'nullable',
            'due_date' => 'required|date'
        ]);

        $activity = Activity::create($validated);

        return response()->json(['data' => $activity], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $activity = Activity::find($id);

        if (!$activity) return response()->json(["message" => "Activity not found"]);

        return response()->json($activity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|max:255',
            'description' => 'sometimes',
            'status'=> 'sometimes',
            'due_date' => 'sometimes|date'
        ]);

        $activity = Activity::find($id);
        if (!$activity) return response()->json(["message" => "Activity not found"]);

        $activity->update($validated);

        return response()->json([
            "message" => "Activity updated",
            "data" => $activity
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
