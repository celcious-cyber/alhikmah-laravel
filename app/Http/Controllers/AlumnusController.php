<?php

namespace App\Http\Controllers;

use App\Models\Alumnus;
use Illuminate\Http\Request;

class AlumnusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all alumni sorted by graduation year
        $alumni = Alumnus::orderBy('graduation_year', 'desc')->get();
        
        // Distribution stats
        $distribution = $alumni->groupBy('country')->map(function ($group) {
            return $group->count();
        })->sortDesc();

        // Featured alumni
        $featured = $alumni->where('is_featured', true)->values();

        return response()->json([
            'alumni' => $alumni,
            'distribution' => $distribution,
            'featured' => $featured,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumnus $alumnus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumnus $alumnus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumnus $alumnus)
    {
        //
    }
}
