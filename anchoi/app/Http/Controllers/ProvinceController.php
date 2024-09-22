<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return response()->json($provinces);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
        ]);

        $province = Province::create($request->all());
        return response()->json($province, Response::HTTP_CREATED);
    }

    // Lấy thông tin một tỉnh theo ID
    public function show($id)
    {
        $province = Province::find($id);

        if (!$province) {
            return response()->json(['message' => 'Province not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($province);
    }

    // Cập nhật thông tin tỉnh theo ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
        ]);

        $province = Province::find($id);

        if (!$province) {
            return response()->json(['message' => 'Province not found'], Response::HTTP_NOT_FOUND);
        }

        $province->update($request->all());
        return response()->json($province);
    }

    // Xóa tỉnh theo ID
    public function destroy($id)
    {
        $province = Province::find($id);

        if (!$province) {
            return response()->json(['message' => 'Province not found'], Response::HTTP_NOT_FOUND);
        }

        $province->delete();
        return response()->json(['message' => 'Province deleted']);
    }
    // viết hàm tìm kiếm tỉnh theo slug
    public function searchBySlug($slug)
    {
        $province = Province::where('slug', $slug)->first();

        if (!$province) {
            return response()->json(['message' => 'Province not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($province);
    }
}
