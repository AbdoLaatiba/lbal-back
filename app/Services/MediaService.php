<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\JsonResponse;

class MediaService
{
    protected CloudinaryService $cloudinaryService;

    public function __construct()
    {
        $this->cloudinaryService = new CloudinaryService();
    }
    public function deleteMedia($id): JsonResponse
    {
        $media = Media::find($id);
        if ($media) {
            $this->cloudinaryService->delete($media->public_id);
            $media->delete();
            return response()->json(['message' => 'Media deleted successfully'], 200);
        } else {
         return response()->json(['message' => 'Media not found'], 404);
        }
    }

    public function deleteAll($ids): JsonResponse
    {
        $media = Media::whereIn('id', $ids)->get();
        $publicIds = $media->map(function ($m) {
            return $m->public_id;
        });
        $this->cloudinaryService->deleteAll($publicIds);
        Media::destroy($ids);
        return response()->json(['message' => 'Media deleted successfully'], 200);
    }
}
