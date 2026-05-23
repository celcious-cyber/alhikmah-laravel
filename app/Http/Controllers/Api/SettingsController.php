<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Display all settings as key-value pairs.
     */
    public function index()
    {
        try {
            $rows = Setting::select('key', 'value')->get();
            
            // Map rows to key-value pairs to match old API format
            $settings = $rows->reduce(function ($acc, $row) {
                $acc[$row->key] = $row->value;
                return $acc;
            }, []);

            return response()->json($settings);
        } catch (\Exception $e) {
            Log::error('Error fetching settings: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil data pengaturan.'], 500);
        }
    }

    /**
     * Update multiple settings in batch.
     */
    public function updateBatch(Request $request)
    {
        try {
            $settings = $request->all();

            foreach ($settings as $key => $value) {
                // Ensure value is a string or cast properly
                $valStr = is_array($value) ? json_encode($value) : ($value ?? '');
                
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $valStr]
                );
            }

            return response()->json(['message' => 'Konten berhasil diperbarui.']);
        } catch (\Exception $e) {
            Log::error('Error updating settings batch: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memperbarui konten.'], 500);
        }
    }
}
