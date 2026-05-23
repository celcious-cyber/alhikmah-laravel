<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of published news (public).
     */
    public function index()
    {
        try {
            $news = News::where('isPublished', true)
                        ->with(['categories', 'author'])
                        ->orderBy('createdAt', 'desc')
                        ->select('id', 'title', 'slug', 'excerpt', 'thumbnail', 'createdAt')
                        ->get();

            $headline = $news->first();
            $list = $news->slice(1)->values();

            return response()->json([
                'headline' => $headline,
                'list' => $list
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching public news: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil berita.'], 500);
        }
    }

    public function indexAdmin()
    {
        try {
            $news = News::orderBy('createdAt', 'desc')->get();
            return response()->json($news);
        } catch (\Exception $e) {
            Log::error('Error fetching admin news: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil berita.'], 500);
        }
    }

    /**
     * Display a listing of popular news (public).
     */
    public function popular()
    {
        try {
            $news = News::where('isPublished', true)
                        ->with(['categories', 'author'])
                        ->orderBy('views_count', 'desc')
                        ->orderBy('createdAt', 'desc')
                        ->take(5)
                        ->select('id', 'title', 'slug', 'excerpt', 'thumbnail', 'createdAt', 'views_count')
                        ->get();
            return response()->json($news);
        } catch (\Exception $e) {
            Log::error('Error fetching popular news: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil berita populer.'], 500);
        }
    }

    /**
     * Display featured news for the homepage (public).
     */
    public function featured()
    {
        try {
            $featuredIdsJson = \Illuminate\Support\Facades\DB::table('Settings')->where('key', 'featured_news')->value('value');
            $featuredIds = $featuredIdsJson ? json_decode($featuredIdsJson, true) : [];
            
            $query = News::where('isPublished', true)
                        ->with(['categories', 'author'])
                        ->select('id', 'title', 'slug', 'excerpt', 'thumbnail', 'createdAt');
            
            if (!empty($featuredIds) && is_array($featuredIds)) {
                $fetchedNews = $query->whereIn('id', $featuredIds)->get();
                // Sort manually in PHP to support SQLite
                $news = $fetchedNews->sortBy(function ($item) use ($featuredIds) {
                    return array_search($item->id, $featuredIds);
                })->values();
            } else {
                $news = $query->orderBy('createdAt', 'desc')
                              ->take(3)
                              ->get();
            }
            
            return response()->json($news);
        } catch (\Exception $e) {
            Log::error('Error fetching featured news: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil berita.'], 500);
        }
    }

    /**
     * Display the specified news by slug (public).
     */
    public function showBySlug($slug)
    {
        try {
            $news = News::where('slug', $slug)->with(['comments', 'categories', 'author'])->first();
            
            if (!$news) {
                return response()->json(['message' => 'Berita tidak ditemukan.'], 404);
            }
            
            if (!$news->isPublished) {
                return response()->json(['message' => 'Berita belum dipublikasikan.'], 404);
            }
            
            // Increment views count
            $news->increment('views_count');
            
            return response()->json($news);
        } catch (\Exception $e) {
            Log::error('Error fetching news by slug: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil berita.'], 500);
        }
    }

    /**
     * Store a newly created news in storage (admin).
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'required|string|max:1000',
                'content' => 'required|string',
                'isPublished' => 'nullable', // string or boolean
                'thumbnail' => 'nullable', // file or string URL
            ]);

            $thumbnailUrl = null;

            if ($request->hasFile('thumbnail')) {
                $thumbnailUrl = $this->processImage($request->file('thumbnail'));
            } elseif ($request->input('thumbnail')) {
                $thumbnailUrl = $request->input('thumbnail');
            }

            // Generate unique slug
            $slug = Str::slug($validated['title']) . '-' . rand(1000, 9999);
            
            // Map published flag
            $isPublished = filter_var($request->input('isPublished'), FILTER_VALIDATE_BOOLEAN);

            $news = News::create([
                'title' => $validated['title'],
                'slug' => $slug,
                'excerpt' => $validated['excerpt'],
                'content' => $validated['content'],
                'thumbnail' => $thumbnailUrl,
                'isPublished' => $isPublished,
            ]);

            return response()->json($news, 201);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $ve->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creating news: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menyimpan ke database: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified news in storage (admin).
     */
    public function update(Request $request, $id)
    {
        try {
            $news = News::find($id);
            if (!$news) {
                return response()->json(['message' => 'Berita tidak ditemukan.'], 404);
            }

            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'excerpt' => 'nullable|string|max:1000',
                'content' => 'nullable|string',
                'isPublished' => 'nullable',
                'thumbnail' => 'nullable',
            ]);

            $updateData = [];

            if ($request->has('title')) {
                $updateData['title'] = $validated['title'];
                // Update slug only if title changes
                $updateData['slug'] = Str::slug($validated['title']) . '-' . rand(1000, 9999);
            }

            if ($request->has('excerpt')) {
                $updateData['excerpt'] = $validated['excerpt'];
            }

            if ($request->has('content')) {
                $updateData['content'] = $validated['content'];
            }

            if ($request->hasFile('thumbnail')) {
                // Delete old physical image if it was uploaded
                if ($news->thumbnail && Str::startsWith($news->thumbnail, '/uploads/news/')) {
                    $oldFilePath = public_path(ltrim($news->thumbnail, '/'));
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }
                $updateData['thumbnail'] = $this->processImage($request->file('thumbnail'));
            } elseif ($request->has('thumbnail')) {
                $updateData['thumbnail'] = $validated['thumbnail'] ?: null;
            }

            if ($request->has('isPublished')) {
                $updateData['isPublished'] = filter_var($request->input('isPublished'), FILTER_VALIDATE_BOOLEAN);
            }

            $news->update($updateData);

            return response()->json($news);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $ve->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error updating news: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengubah berita: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified news from storage (admin).
     */
    public function destroy($id)
    {
        try {
            $news = News::find($id);
            if (!$news) {
                return response()->json(['message' => 'Berita tidak ditemukan.'], 404);
            }

            // Delete physical image file
            if ($news->thumbnail && Str::startsWith($news->thumbnail, '/uploads/news/')) {
                $filePath = public_path(ltrim($news->thumbnail, '/'));
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            $news->delete();
            return response()->json(['message' => 'Berita berhasil dihapus.']);
        } catch (\Exception $e) {
            Log::error('Error deleting news: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus berita.'], 500);
        }
    }

    /**
     * Increment shares count for a news article.
     */
    public function share($id)
    {
        try {
            $news = News::find($id);
            if ($news) {
                $news->increment('shares_count');
                return response()->json(['shares_count' => $news->shares_count]);
            }
            return response()->json(['message' => 'Not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    /**
     * Submit a comment to a news article.
     */
    public function comment(Request $request, $id)
    {
        try {
            $news = News::find($id);
            if (!$news) {
                return response()->json(['message' => 'Berita tidak ditemukan.'], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'content' => 'required|string|max:1000',
            ]);

            $comment = $news->comments()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'content' => $validated['content'],
            ]);

            return response()->json($comment, 201);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $ve->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error adding comment: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menambahkan komentar.'], 500);
        }
    }

    /**
     * Helper: Process and save image, crop to 1200x750 WebP if GD available.
     */
    private function processImage($file)
    {
        $destinationPath = public_path('uploads/news');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $uniqueName = 'news-' . time() . '-' . rand(100000000, 999999999);
        
        // Try resizing & converting to WebP using GD library
        if (extension_loaded('gd')) {
            try {
                $src = null;
                $extension = strtolower($file->getClientOriginalExtension());
                $mimeType = $file->getClientMimeType();
                
                if ($extension === 'jpg' || $extension === 'jpeg' || $mimeType === 'image/jpeg') {
                    $src = imagecreatefromjpeg($file->getRealPath());
                } elseif ($extension === 'png' || $mimeType === 'image/png') {
                    $src = imagecreatefrompng($file->getRealPath());
                } elseif ($extension === 'webp' || $mimeType === 'image/webp') {
                    $src = imagecreatefromwebp($file->getRealPath());
                } elseif ($extension === 'gif' || $mimeType === 'image/gif') {
                    $src = imagecreatefromgif($file->getRealPath());
                }
                
                if ($src) {
                    $width = imagesx($src);
                    $height = imagesy($src);
                    
                    $targetWidth = 1200;
                    $targetHeight = 750;
                    
                    $ratio = max($targetWidth / $width, $targetHeight / $height);
                    
                    $tmp = imagecreatetruecolor($targetWidth, $targetHeight);
                    
                    // Maintain alpha transparency
                    imagealphablending($tmp, false);
                    imagesavealpha($tmp, true);
                    
                    $srcX = round(($width - ($targetWidth / $ratio)) / 2);
                    $srcY = round(($height - ($targetHeight / $ratio)) / 2);
                    
                    imagecopyresampled(
                        $tmp, $src, 
                        0, 0, 
                        $srcX, $srcY, 
                        $targetWidth, $targetHeight, 
                        round($targetWidth / $ratio), round($targetHeight / $ratio)
                    );
                    
                    $fileName = $uniqueName . '.webp';
                    $filePath = $destinationPath . '/' . $fileName;
                    
                    imagewebp($tmp, $filePath, 80);
                    
                    imagedestroy($src);
                    imagedestroy($tmp);
                    
                    return '/uploads/news/' . $fileName;
                }
            } catch (\Exception $e) {
                Log::warning('GD resize failed, using fallback: ' . $e->getMessage());
            }
        }
        
        // Fallback: move the original file as is
        $fileName = $uniqueName . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);
        return '/uploads/news/' . $fileName;
    }
}
