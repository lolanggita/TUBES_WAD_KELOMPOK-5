<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\UKM;
use Illuminate\Support\Facades\Validator;

class UkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ukms = UKM::all();
        return response()->json([
            'message' => 'Data UKM berhasil diambil.',
            'data' => $ukms
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Simpan data
        $data = $request->only(['name', 'description', 'contact']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $ukm = UKM::create($data);

        return response()->json([
            'message' => 'Data UKM berhasil disimpan.',
            'data' => $ukm
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(UKM $ukm)
    {
        return response()->json([
            'message' => 'Detail UKM berhasil diambil.',
            'data' => $ukm
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UKM $ukm)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'contact' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $request->only(['name', 'description', 'contact']);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($ukm->logo) {
                Storage::disk('public')->delete($ukm->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $ukm->update($data);

        return response()->json([
            'message' => 'Data UKM berhasil diperbarui.',
            'data' => $ukm
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UKM $ukm)
    {
        if ($ukm->logo) {
            Storage::disk('public')->delete($ukm->logo);
        }

        $ukm->delete();

        return response()->json([
            'message' => 'Data UKM berhasil dihapus.'
        ], Response::HTTP_OK);
    }
}