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
        $totalPutra = \Illuminate\Support\Facades\DB::table('Settings')->where('key', 'total_alumni_putra')->value('value');
        $totalPutri = \Illuminate\Support\Facades\DB::table('Settings')->where('key', 'total_alumni_putri')->value('value');

        if ($totalPutra !== null && $totalPutri !== null) {
            $totalAlumni = (int)$totalPutra + (int)$totalPutri;
        } else {
            $totalAlumni = $alumni->count();
        }

        return response()->json([
            'alumni' => $alumni,
            'distribution' => $distribution,
            'featured' => $featured,
            'total_count' => $totalAlumni,
            'total_putra' => $totalPutra !== null ? (int)$totalPutra : null,
            'total_putri' => $totalPutri !== null ? (int)$totalPutri : null,
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
