<?php

namespace App\Http\Controllers\Api;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;


class GalleryController extends Controller
{
    /**
     * Apply middleware to this controller.
     */
    public function __construct()
    {
        // Pastikan user login via Sanctum dan memiliki role 'ukm'
        $this->middleware('auth:sanctum');
        $this->middleware('role:ukm'); // Harus sudah terdaftar di Kernel
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $galleries = Auth::user()->galleries;

        return response()->json([
            'success' => true,
            'data' => $galleries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image')->store('galleries', 'public');

        $gallery = Auth::user()->galleries()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diupload.',
            'data' => $gallery
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->ukm_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke foto ini.');
        }

        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->ukm_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke foto ini.');
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image_path);
            $path = $request->file('image')->store('galleries', 'public');
            $gallery->image_path = $path;
        }

        $gallery->title = $request->input('title', $gallery->title);
        $gallery->description = $request->input('description', $gallery->description);
        $gallery->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diperbarui.',
            'data' => $gallery
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->ukm_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke foto ini.');
        }

        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus.'
        ]);
    }
}