<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EntertainmentType;
use Illuminate\Http\Response;
class EntertainmentTypeController extends Controller
{
    public function index()
    {
        $entertaimentTypes = EntertainmentType::all();
        return response()->json($entertaimentTypes);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type'=> 'nullable|string',
        ]);

        $entertaimentType = EntertainmentType::create($request->all());
        return response()->json($entertaimentType, Response::HTTP_CREATED);
    }
    public function show($id)
    {
        $entertaimentType = EntertainmentType::find($id);

        if (!$entertaimentType) {
            return response()->json(['message' => 'EntertaimentType not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($entertaimentType);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type'=> 'nullable|string',
        ]);

        $entertaimentType = EntertainmentType::find($id);

        if (!$entertaimentType) {
            return response()->json(['message' => 'EntertaimentType not found'], Response::HTTP_NOT_FOUND);
        }

        $entertaimentType->update($request->all());
        return response()->json($entertaimentType);
    }
    public function destroy($id)
    {
        $entertaimentType = EntertainmentType::find($id);

        if (!$entertaimentType) {
            return response()->json(['message' => 'EntertaimentType not found'], Response::HTTP_NOT_FOUND);
        }

        $entertaimentType->delete();
        return response()->json(['message' => 'EntertaimentType deleted']);
    }
}
