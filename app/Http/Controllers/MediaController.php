<?php

namespace App\Http\Controllers;

use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Services\CloudinaryService;

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
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $file = $request->file('file');

        $res = $this->cloudinaryService->upload($file);


        $media = Media::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $res['path'],
            'public_id' => $res['public_id'],
            'type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'extension' => $file->extension(),
            'mime_type' => $file->getMimeType()
        ]);

        return response()->json($media, 201);
    }

    public function destroy($id): JsonResponse
    {
       return $this->mediaService->deleteMedia($id);
    }

    public function destroyAll(Request $request)
    {
        $ids = $request->input('ids');
        return $this->mediaService->deleteAll($ids);
    }

    public function show($id)
    {
        $media = Media::find($id);

        if(!$media){
            return response()->json([
                'message' => 'Media not found'
            ]);
        }

        return response()->json($media);
    }

    public function index()
    {
        $media = Media::all();

        return response()->json($media);
    }

    public function download($id)
    {
        $media = Media::find($id);

        if(!$media){
            return response()->json([
                'message' => 'Media not found'
            ]);
        }

        // download file from cloudinary url
        $tempFile = tempnam(sys_get_temp_dir(), $media->public_id);
        copy($media->path, $tempFile);

        return response()->download($tempFile, $media->filename);
    }
}
