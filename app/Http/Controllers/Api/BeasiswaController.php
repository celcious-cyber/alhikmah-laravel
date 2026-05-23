<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BeasiswaController extends Controller
{
    /**
     * Display a listing of the resource (admin).
     */
    public function index()
    {
        try {
            $scholarships = Beasiswa::orderBy('created_at', 'desc')->get();
            $mapped = $scholarships->map(function ($s) {
                $s->id_str = (string)$s->id;
                return $s;
            });
            return response()->json($mapped);
        } catch (\Exception $e) {
            Log::error('Error fetching scholarships: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil data beasiswa.'], 500);
        }
    }

    /**
     * Store a newly created scholarship application (public).
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except(['file_sertifikat', 'file_sk_hafalan', 'file_sktm', 'file_rekomendasi', 'file_komitmen']);

            if (!isset($data['nama_lengkap']) || empty($data['nama_lengkap'])) {
                return response()->json(['success' => false, 'message' => 'Nama lengkap wajib diisi.'], 400);
            }
            if (!isset($data['jenis_beasiswa']) || empty($data['jenis_beasiswa'])) {
                return response()->json(['success' => false, 'message' => 'Jenis beasiswa wajib dipilih.'], 400);
            }

            // Create target directory in public/uploads/beasiswa
            $destinationPath = public_path('uploads/beasiswa');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $fileFields = ['file_sertifikat', 'file_sk_hafalan', 'file_sktm', 'file_rekomendasi', 'file_komitmen'];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $uniqueSuffix = time() . '-' . rand(100000000, 999999999);
                    $fileName = $field . '-' . $uniqueSuffix . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $fileName);
                    $data[$field] = '/uploads/beasiswa/' . $fileName;
                } else {
                    $data[$field] = null;
                }
            }

            // Generate registration number: BEA-2026-[RANDOM_4_DIGIT]
            $randomNum = rand(1000, 9999);
            $data['no_registrasi'] = 'BEA-2026-' . $randomNum;
            $data['verified'] = false;

            $scholarship = Beasiswa::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran beasiswa berhasil terkirim!',
                'data' => [
                    'id' => (string)$scholarship->id,
                    'no_registrasi' => $scholarship->no_registrasi
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error storing scholarship application: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Gagal mengirim pendaftaran beasiswa.'
            ], 500);
        }
    }

    /**
     * Display status check for scholarship (public).
     */
    public function checkStatus($no_registrasi)
    {
        try {
            $scholarship = Beasiswa::where('no_registrasi', $no_registrasi)
                                   ->select('id', 'no_registrasi', 'nama_lengkap', 'jenis_beasiswa', 'verified', 'created_at')
                                   ->first();
                                   
            if (!$scholarship) {
                return response()->json(['message' => 'Nomor registrasi beasiswa tidak ditemukan.'], 404);
            }
            
            return response()->json($scholarship);
        } catch (\Exception $e) {
            Log::error('Error checking scholarship status: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memeriksa status beasiswa.'], 500);
        }
    }

    /**
     * Update verification status (admin).
     */
    public function verify(Request $request, $id)
    {
        try {
            $scholarship = Beasiswa::find($id);
            if (!$scholarship) {
                return response()->json(['message' => 'Data beasiswa tidak ditemukan.'], 404);
            }

            $verified = filter_var($request->input('verified'), FILTER_VALIDATE_BOOLEAN);

            $scholarship->update([
                'verified' => $verified
            ]);

            return response()->json($scholarship);
        } catch (\Exception $e) {
            Log::error('Error verifying scholarship: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengubah status verifikasi beasiswa.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage (admin).
     */
    public function destroy($id)
    {
        try {
            $scholarship = Beasiswa::find($id);
            if (!$scholarship) {
                return response()->json(['message' => 'Data beasiswa tidak ditemukan.'], 404);
            }

            // List of file fields to delete physical documents
            $fileFields = ['file_sertifikat', 'file_sk_hafalan', 'file_sktm', 'file_rekomendasi', 'file_komitmen'];

            foreach ($fileFields as $field) {
                if ($scholarship->$field && Str::startsWith($scholarship->$field, '/uploads/beasiswa/')) {
                    $filePath = public_path(ltrim($scholarship->$field, '/'));
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }

            $scholarship->delete();
            return response()->json(['success' => true, 'message' => 'Data beasiswa berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error('Error deleting scholarship: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus data beasiswa.'], 500);
        }
    }
}
