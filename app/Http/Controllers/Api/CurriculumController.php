<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function index()
    {
        $curricula = Curriculum::orderBy('order', 'asc')->get();
        $curricula->transform(fn ($c) => $this->transformUrls($c));
        return response()->json($curricula);
    }

    public function show(string $type)
    {
        $curriculum = Curriculum::where('type', $type)->first();
        if (!$curriculum) {
            return response()->json(['message' => 'Tidak ditemukan'], 404);
        }
        return response()->json($this->transformUrls($curriculum));
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

    public function achievements()
    {
        $curricula = Curriculum::all();
        $achievements = [];
        
        foreach ($curricula as $c) {
            if ($c->achievements) {
                foreach ($c->achievements as $ach) {
                    $ach['source'] = $c->name;
                    $ach['source_type'] = $c->type;
                    $achievements[] = $ach;
                }
            }
        }

        // Sort by year descending
        usort($achievements, function($a, $b) {
            return ($b['year'] ?? 0) <=> ($a['year'] ?? 0);
        });

        return response()->json($achievements);
    }
}
