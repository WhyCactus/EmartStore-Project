<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Kreait\Firebase\Contract\Storage;

class FirebaseStorageService
{
    protected $bucket;

    public function __construct(Storage $storage)
    {
        $this->bucket = $storage->getBucket('emart-1eb6c.firebasestorage.app');
    }

    public function uploadProductImage(UploadedFile $file)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $filePath = 'products/' . $fileName;

        $this->bucket->upload(
            fopen($file->getPathname(), 'r'),
            [
                'name' => $filePath,
                'predefinedAcl' => 'publicRead',
                'metadata' => [
                    'contentType' => $file->getClientMimeType(),
                ],
            ]
        );

        return [
            'path' => $filePath,
            'url' => $this->getPublicUrl($filePath),
            'name' => $fileName
        ];
    }

    public function uploadVarnishImage(UploadedFile $file)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $filePath = 'products_variants/' . $fileName;

        $this->bucket->upload(
            fopen($file->getPathname(), 'r'),
            [
                'name' => $filePath,
                'predefinedAcl' => 'publicRead',
                'metadata' => [
                    'contentType' => $file->getClientMimeType(),
                ],
            ]
        );

        return [
            'path' => $filePath,
            'url' => $this->getPublicUrl($filePath),
            'name' => $fileName
        ];
    }

    private function getPublicUrl($filePath)
    {
        $bucketName = $this->bucket->name();
        return "https://storage.googleapis.com/{$bucketName}/{$filePath}";
    }

    public function delete(string $path)
    {
        try {
            $this->bucket->object($path)->delete();
            return true;
        } catch (\Throwable $e) {
            \Log::error("Failed to delete file from Firebase Storage: " . $e->getMessage());
            return false;
        }
    }

    public function exits(string $path)
    {
        try {
            return $this->bucket->object($path)->exists();
        } catch (\Throwable $e) {
            \Log::error("Failed to check if file exists in Firebase Storage: " . $e->getMessage());
            return false;
        }
    }
}
