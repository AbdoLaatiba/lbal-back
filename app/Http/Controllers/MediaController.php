<?php

namespace App\Http\Controllers;

use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Services\CloudinaryService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    protected MediaService $mediaService;
    protected CloudinaryService $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService, MediaService $mediaService)
    {
        $this->cloudinaryService = $cloudinaryService;
        $this->mediaService = $mediaService;
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp'
        ]);

        $file = $request->file('file');

        $res = $this->mediaService->upload($file);


        $media = Media::create([
            'filename' => $res['filename'],
            'path' => $res['path'],
            'size' => $res['size'],
            'extension' => $res['extension'],
            'mime_type' => $res['mime_type']
        ]);

        return response()->json($res, 201);
    }

    public function destroy($id): JsonResponse
    {
       return $this->mediaService->deleteMedia($id);
    }

    public function destroyAll(Request $request): JsonResponse
    {
        $ids = $request->input('ids');
        return $this->mediaService->deleteAll($ids);
    }

    public function show($id): JsonResponse
    {
        return $this->mediaService->getMedia($id);
    }

    public function index(): JsonResponse
    {
        return $this->mediaService->getAllMedia();
    }

    public function download($id): StreamedResponse
    {
        return $this->mediaService->downloadMedia($id);
    }

    public function preview($id): BinaryFileResponse
    {
        return $this->mediaService->previewMedia($id);
    }
}
