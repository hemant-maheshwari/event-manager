<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $event = Event::create($request->all());

        return response()->json($event, 201);
    }

    public function show($id)
    {
        $event = Event::find($id);
        if (is_null($event)) {
            return response()->json(['message' => 'Event Not Found'], 404);
        }
        return response()->json($event, 200);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (is_null($event)) {
            return response()->json(['message' => 'Event Not Found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $event->update($request->all());

        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if (is_null($event)) {
            return response()->json(['message' => 'Event Not Found'], 404);
        }

        $event->delete();
        return response()->json(null, 204);
    }
}
