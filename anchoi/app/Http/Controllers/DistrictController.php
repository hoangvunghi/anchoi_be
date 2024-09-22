<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use Illuminate\Http\Response;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::all();
        return response()->json($districts);
    }
    // thêm 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'province_id' => 'required|integer|exists:tinh,id',
        ]);

        $district = District::create($request->all());
        return response()->json($district, Response::HTTP_CREATED);
    }
    // hiển thị theo id
    public function show($id)
    {
        $district = District::find($id);

        if (!$district) {
            return response()->json(['message' => 'District not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($district);
    }
    // cập nhật theo id
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'province_id' => 'nullable|integer|exists:tinh,id',
        ]);

        $district = District::find($id);

        if (!$district) {
            return response()->json(['message' => 'District not found'], Response::HTTP_NOT_FOUND);
        }

        $district->update($request->all());
        return response()->json($district);
    }
    // xóa theo id
    public function destroy($id)
    {
        $district = District::find($id);

        if (!$district) {
            return response()->json(['message' => 'District not found'], Response::HTTP_NOT_FOUND);
        }

        $district->delete();
        return response()->json(['message' => 'District deleted']);
    }
    // truyền vào id tỉnh lấy ra tất cả quận huyện của tỉnh đó
    public function getDistrictByProvince($id)
    {
        $districts = District::where('province_id', $id)->get();
        return response()->json($districts);
    }
    public function searchBySlug($slug)
    {
        $district = District::where('slug', $slug)->first();

        if (!$district) {
            return response()->json(['message' => 'District not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($district);
    }
}
