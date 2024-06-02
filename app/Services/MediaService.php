<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Intervention\Image\ImageManager;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaService
{
    protected OptimizerChain $optimizer;
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->optimizer = OptimizerChainFactory::create();
        $this->imageManager = new ImageManager(Driver::class);
    }

    public function upload($file): array
    {
        // Generate a unique filename
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time();
        $extension = $file->getClientOriginalExtension();
        $filePath = 'uploads/' . $filename . '.' . $extension;

        // Resize and maintain aspect ratio
        $image = $this->imageManager->read($file->getRealPath())
            ->scaleDown(800, null);

        // Convert to WebP
        $webpPath = 'uploads/' . $filename . '.webp';
        $image->save(storage_path('app/' . $webpPath), 80, 'webp');

        // Optimize the WebP image
        $this->optimizer->optimize(storage_path('app/' . $webpPath));

        return [
            'path' => $webpPath,
            'filename' => $filename,
            'extension' => 'webp',
            'mime_type' => 'image/webp',
            'size' => Storage::size($webpPath),
        ];
    }

    public function deleteMedia($id): JsonResponse
    {
        $media = Media::find($id);
        if (!$media) {
            return response()->json([
                'message' => 'Media not found'
            ], 404);
        }
        Storage::delete($media->path);
        $media->delete();
        return response()->json([
            'message' => 'Media deleted successfully'
        ], 200);
    }

    public function deleteAll($ids): JsonResponse
    {
        $media = Media::find($ids);
        foreach ($media as $m) {
            Storage::delete($m->path);
            $m->delete();
        }
        return response()->json(null, 204);
    }

    public function getMedia($id): JsonResponse
    {
        $media = Media::find($id);
        if (!$media) {
            return response()->json([
                'message' => 'Media not found'
            ], 404);
        }
        return response()->json($media, 200);
    }

    public function getAllMedia(): JsonResponse
    {
        $media = Media::all();
        return response()->json($media, 200);
    }

    public function downloadMedia($id): StreamedResponse
    {
        $media = Media::find($id);
        return Storage::download($media->path);
    }

    public function previewMedia($id): BinaryFileResponse
    {
        $media = Media::find($id);
        return response()->file(storage_path('app/' . $media->path));
    }
}
