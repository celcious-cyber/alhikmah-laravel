<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource (admin).
     */
    public function index()
    {
        try {
            $registrations = Pendaftaran::orderBy('created_at', 'desc')->get();
            // Map ID to string to mimic Node's JSON response for large numbers if needed
            $mapped = $registrations->map(function ($reg) {
                $reg->id_str = (string)$reg->id;
                return $reg;
            });
            return response()->json($mapped);
        } catch (\Exception $e) {
            Log::error('Error fetching registrations: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil data pendaftaran.'], 500);
        }
    }

    /**
     * Store a newly created registration (public).
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except(['foto_3x4', 'file_ijazah', 'file_surat_lulus', 'file_akte_lahir', 'file_kk', 'file_kartu_nisn', 'file_kartu_kip', 'file_kartu_pkh', 'file_kartu_kks', 'file_foto_rapot']);
            
            // Check for required base fields
            if (!isset($data['nama_lengkap']) || empty($data['nama_lengkap'])) {
                return response()->json(['success' => false, 'message' => 'Nama lengkap wajib diisi.'], 400);
            }

            // Create target directory in public/uploads/pendaftaran
            $destinationPath = public_path('uploads/pendaftaran');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $fileFields = [
                'foto_3x4', 'file_ijazah', 'file_surat_lulus', 'file_akte_lahir', 
                'file_kk', 'file_kartu_nisn', 'file_kartu_kip', 'file_kartu_pkh', 
                'file_kartu_kks', 'file_foto_rapot'
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $uniqueSuffix = time() . '-' . rand(100000000, 999999999);
                    $fileName = $field . '-' . $uniqueSuffix . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $fileName);
                    $data[$field] = '/uploads/pendaftaran/' . $fileName;
                }
            }

            // Generate registration number: ALH-[YEAR]-[RANDOM_4_DIGIT]
            $year = date('Y');
            $random = rand(1000, 9999);
            $data['no_registrasi'] = 'ALH-' . $year . '-' . $random;
            $data['verified'] = false;

            $registration = Pendaftaran::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil disimpan',
                'data' => [
                    'id' => (string)$registration->id,
                    'no_registrasi' => $registration->no_registrasi
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error storing registration: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan pendaftaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display status check for registration (public).
     */
    public function checkStatus($no_registrasi)
    {
        try {
            $registration = Pendaftaran::where('no_registrasi', $no_registrasi)
                                       ->select('id', 'no_registrasi', 'nama_lengkap', 'asal_sekolah', 'verified', 'created_at')
                                       ->first();
                                       
            if (!$registration) {
                return response()->json(['message' => 'Nomor registrasi tidak ditemukan.'], 404);
            }
            
            return response()->json($registration);
        } catch (\Exception $e) {
            Log::error('Error checking registration status: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memeriksa status registrasi.'], 500);
        }
    }

    /**
     * Display the specified resource (admin).
     */
    public function show($id)
    {
        try {
            $registration = Pendaftaran::find($id);
            if (!$registration) {
                return response()->json(['message' => 'Pendaftaran tidak ditemukan.'], 404);
            }
            return response()->json($registration);
        } catch (\Exception $e) {
            Log::error('Error showing registration: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menampilkan detail.'], 500);
        }
    }

    /**
     * Update verification status (admin).
     */
    public function verify(Request $request, $id)
    {
        try {
            $registration = Pendaftaran::find($id);
            if (!$registration) {
                return response()->json(['message' => 'Pendaftaran tidak ditemukan.'], 404);
            }

            // Get current authenticated admin username from custom middleware
            $adminUsername = $request->attributes->get('admin_username') ?? 'admin';
            
            $verified = filter_var($request->input('verified'), FILTER_VALIDATE_BOOLEAN);

            $registration->update([
                'verified' => $verified,
                'verified_by' => $verified ? $adminUsername : null
            ]);

            return response()->json($registration);
        } catch (\Exception $e) {
            Log::error('Error verifying registration: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengubah status verifikasi.'], 500);
        }
    }

    /**
     * Export pendaftaran list to CSV (admin).
     */
    public function export(Request $request)
    {
        try {
            $data = Pendaftaran::orderBy('created_at', 'desc')->get();
            
            $headers = [
                'No Registrasi', 'Nama Lengkap', 'Email', 'NISN', 'NIK', 'Tempat Lahir', 
                'Tanggal Lahir', 'Jenis Kelamin', 'Asal Sekolah', 'Nama Ayah', 'Nama Ibu', 
                'Status Verifikasi', 'Tanggal Daftar'
            ];
            
            $csvData = [];
            $csvData[] = implode(',', array_map(function($h) { return '"' . str_replace('"', '""', $h) . '"'; }, $headers));
            
            foreach ($data as $r) {
                $row = [
                    $r->no_registrasi, 
                    $r->nama_lengkap, 
                    $r->email_pendaftar, 
                    $r->nisn, 
                    $r->nik, 
                    $r->tempat_lahir,
                    $r->tanggal_lahir,
                    $r->jenis_kelamin,
                    $r->asal_sekolah,
                    $r->nama_ayah_kandung,
                    $r->nama_ibu_kandung,
                    $r->verified ? 'Terverifikasi' : 'Belum Verifikasi',
                    $r->created_at ? $r->created_at->format('d/m/Y') : ''
                ];
                $csvData[] = implode(',', array_map(function($cell) { 
                    return '"' . str_replace('"', '""', $cell ?? '') . '"'; 
                }, $row));
            }
            
            $csv = implode("\n", $csvData);
            
            return response($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=pendaftaran_al_hikmah.csv'
            ]);
        } catch (\Exception $e) {
            Log::error('Error exporting registrations CSV: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal export data.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage (admin).
     */
    public function destroy($id)
    {
        try {
            $registration = Pendaftaran::find($id);
            if (!$registration) {
                return response()->json(['message' => 'Pendaftaran tidak ditemukan.'], 404);
            }

            // List of file fields to delete physical files
            $fileFields = [
                'foto_3x4', 'file_ijazah', 'file_surat_lulus', 'file_akte_lahir', 
                'file_kk', 'file_kartu_nisn', 'file_kartu_kip', 'file_kartu_pkh', 
                'file_kartu_kks', 'file_foto_rapot'
            ];

            foreach ($fileFields as $field) {
                if ($registration->$field && Str::startsWith($registration->$field, '/uploads/pendaftaran/')) {
                    $filePath = public_path(ltrim($registration->$field, '/'));
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }

            $registration->delete();
            return response()->json(['success' => true, 'message' => 'Pendaftaran berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error('Error deleting registration: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus data.'], 500);
        }
    }
}
