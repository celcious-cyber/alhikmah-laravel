<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Facility::orderBy('order', 'asc')->get();
        
        $facilities->transform(function ($item) {
            if ($item->imageUrl && !str_starts_with($item->imageUrl, 'http') && !str_starts_with($item->imageUrl, '/')) {
                $item->imageUrl = '/storage/' . $item->imageUrl;
            }
            return $item;
        });

        return response()->json($facilities);
    }
}
