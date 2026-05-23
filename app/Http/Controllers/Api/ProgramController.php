<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $programs = Program::orderBy('order', 'asc')->get();
            $programs->transform(function ($item) {
                if ($item->imageUrl && !str_starts_with($item->imageUrl, 'http') && !str_starts_with($item->imageUrl, '/')) {
                    $item->imageUrl = '/storage/' . $item->imageUrl;
                }
                // Add slug from title if not present
                $item->slug = \Illuminate\Support\Str::slug($item->title);
                return $item;
            });
            return response()->json($programs);
        } catch (\Exception $e) {
            Log::error('Error fetching programs: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil data program.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'description' => 'required|string',
                'imageUrl' => 'nullable|string|max:1000',
                'order' => 'nullable|integer',
            ]);

            $program = Program::create([
                'title' => $validated['title'],
                'category' => $validated['category'],
                'description' => $validated['description'],
                'imageUrl' => $validated['imageUrl'] ?? '',
                'order' => $validated['order'] ?? 0,
            ]);

            return response()->json($program, 201);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $ve->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creating program: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menambah program.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $program = Program::find($id);
            if (!$program) {
                return response()->json(['message' => 'Program tidak ditemukan.'], 404);
            }

            $program->delete();
            return response()->json(['message' => 'Program berhasil dihapus.']);
        } catch (\Exception $e) {
            Log::error('Error deleting program: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus program.'], 500);
        }
    }
}
