<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ward;
use Illuminate\Http\Response;
class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::all();
        return response()->json($wards);
    }
    // Thêm một phường xã mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'district_id' => 'required|integer|exists:quan_huyen,id',
        ]);

        $ward = Ward::create($request->all());
        return response()->json($ward, Response::HTTP_CREATED);
    }
    // Lấy thông tin một phường xã theo ID
    public function show($id)
    {
        $ward = Ward::find($id);

        if (!$ward) {
            return response()->json(['message' => 'Ward not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($ward);
    }
    // Cập nhật thông tin phường xã theo ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'district_id' => 'nullable|integer|exists:quan_huyen,id',
        ]);

        $ward = Ward::find($id);

        if (!$ward) {
            return response()->json(['message' => 'Ward not found'], Response::HTTP_NOT_FOUND);
        }

        $ward->update($request->all());
        return response()->json($ward);
    }
    // Lấy thông tin các phường xã theo quận huyện
    public function getWardByDistrict($id)
    {
        $wards = Ward::where('district_id', $id)->get();
        return response()->json($wards);
    }
    // xóa phường xã theo ID
    public function destroy($id)
    {
        $ward = Ward::find($id);

        if (!$ward) {
            return response()->json(['message' => 'Ward not found'], Response::HTTP_NOT_FOUND);
        }

        $ward->delete();
        return response()->json(['message' => 'Ward deleted']);
    }
    public function search(Request $request)
    {
       
        return response()->json();
    }
}

{}