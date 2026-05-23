<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        if (!$profile) {
            return response()->json(['message' => 'Tidak ditemukan'], 404);
        }
        return response()->json($this->transformUrls($profile));
    }

    private function transformUrls($item)
    {
        foreach (['thumbnail', 'head_photo'] as $field) {
            if ($item->$field && !str_starts_with($item->$field, 'http') && !str_starts_with($item->$field, '/')) {
                $item->$field = '/storage/' . $item->$field;
            }
        }
        return $item;
    }
}
