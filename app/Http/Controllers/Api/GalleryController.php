<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Gallery::query();
            
            if ($request->has('category') && $request->input('category') !== '') {
                $query->where('category', $request->input('category'));
            }
            
            $items = $query->orderBy('order', 'asc')
                          ->orderBy('createdAt', 'desc')
                          ->get();
                          
            $items->transform(function ($item) {
                if ($item->imageUrl && !str_starts_with($item->imageUrl, 'http') && !str_starts_with($item->imageUrl, '/')) {
                    $item->imageUrl = '/storage/' . $item->imageUrl;
                }
                return $item;
            });
                          
            return response()->json($items);
        } catch (\Exception $e) {
            Log::error('Error fetching gallery: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil galeri.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120', // max 5MB
                'caption' => 'nullable|string|max:1000',
                'category' => 'nullable|string|max:255',
                'order' => 'nullable|integer',
            ]);

            if (!$request->hasFile('image')) {
                return response()->json(['message' => 'File gambar wajib diupload.'], 400);
            }

            $file = $request->file('image');
            
            // Create target directory in public/uploads/gallery
            $destinationPath = public_path('uploads/gallery');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Generate unique file name
            $unique = time() . '-' . rand(100000000, 999999999);
            $fileName = 'gallery-' . $unique . '.' . $file->getClientOriginalExtension();
            
            // Move file to target directory
            $file->move($destinationPath, $fileName);
            
            $imageUrl = '/uploads/gallery/' . $fileName;

            $gallery = Gallery::create([
                'imageUrl' => $imageUrl,
                'caption' => $validated['caption'] ?? null,
                'category' => $validated['category'] ?? 'umum',
                'order' => $validated['order'] ?? 0,
            ]);

            return response()->json($gallery, 201);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $ve->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error uploading gallery image: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menyimpan data ke database.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $gallery = Gallery::find($id);
            if (!$gallery) {
                return response()->json(['message' => 'Foto tidak ditemukan.'], 404);
            }

            // Get absolute path of the image and delete it if it exists
            if ($gallery->imageUrl) {
                $filePath = public_path(ltrim($gallery->imageUrl, '/'));
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            $gallery->delete();
            return response()->json(['message' => 'Foto berhasil dihapus.']);
        } catch (\Exception $e) {
            Log::error('Error deleting gallery item: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus foto.'], 500);
        }
    }
}
