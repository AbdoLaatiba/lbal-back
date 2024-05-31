<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    protected $cloudinary;
    // __construct method
    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
                'secure' => true
            ],
        ]);
    }

    public function upload($file, $folder = 'products', $options = [])
    {
        $res = Cloudinary::upload(
            $file->getRealPath(),
            [
                'folder' => $folder,
                'resource_type' => 'auto',
                "transformation" => $options,
            ]
        );
        return [
            'public_id' => $res->getPublicId(),
            'path' => $res->getSecurePath(),
        ];
    }

    public function delete($publicId)
    {
        return Cloudinary::destroy($publicId);
    }

    public function deleteAll($publicIds)
    {
        return Cloudinary::deleteResources($publicIds);
    }

    public function getPublicId($path)
    {
        // regex to get public id from path
        // https://res.cloudinary.com/dzabji4jv/image/upload/v1717095524/t983wa5i49m8pnxrlnwb.png
        // $path = 'v1717095524/t983wa5i49m8pnxrlnwb.png';
        // $publicId = 't983wa5i49m8pnxrlnwb';
        $regex = '/\/v\d+\/(.+)\.\w+$/';
        preg_match($regex, $path, $matches);
        return $matches[1];
    }

    public function getSecurePath($path)
    {
        return Cloudinary::getSecurePath([
            'path' => $path,
            'secure' => true
        ]);
    }

    public function getTransformations($path)
    {
        return Cloudinary::getTransformations($path);
    }

    public function resize($path, $width, $height)
    {
        return Cloudinary::resize($path, $width, $height);
    }
}
