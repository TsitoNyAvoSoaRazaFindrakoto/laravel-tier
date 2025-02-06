<?php

namespace App\Services;

use ImageKit\ImageKit;

class ImageKitService
{
    private $imageKit;

    public function __construct()
    {
        $this->imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.endpoint_url')
        );
    }

    public function uploadImage($file, $userId)
    {
        $fileName = "profile_{$userId}_" . time();
        
        try {
            if (!$file->isValid()) {
                \Log::error('Invalid file provided');
                return null;
            }

            $fileContent = file_get_contents($file->getRealPath());
            if ($fileContent === false) {
                \Log::error('Could not read file contents');
                return null;
            }

            \Log::info('Attempting to upload image to ImageKit', [
                'fileName' => $fileName,
                'fileSize' => $file->getSize(),
                'mimeType' => $file->getMimeType()
            ]);

            // Upload using base64
            $uploadFile = $this->imageKit->upload([
                'file' => $fileContent,
                'fileName' => $fileName,
                'folder' => '/profile-pictures',
                'useUniqueFileName' => true
            ]);
            
            // Vérifier si l'upload a réussi en vérifiant la présence de fileId
            if (isset($uploadFile->result) && isset($uploadFile->result->fileId)) {
                \Log::info('Image uploaded successfully to ImageKit', [
                    'fileId' => $uploadFile->result->fileId,
                    'url' => $uploadFile->result->url ?? null
                ]);
                return $uploadFile->result->fileId;
            }
            
            // Si on arrive ici, c'est qu'il y a eu une erreur
            \Log::error('ImageKit upload failed', [
                'response' => json_encode($uploadFile)
            ]);
            return null;
        } catch (\Exception $e) {
            \Log::error('ImageKit upload error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    public function getImageUrl($fileId)
    {
        if (!$fileId) return null;
        
        try {
            \Log::info('Generating URL for file', ['fileId' => $fileId]);
            
            return $this->imageKit->url([
                'src' => $fileId,
                'transformation' => [
                    [
                        'height' => '300',
                        'width' => '300',
                        'crop' => 'at_max'
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('ImageKit URL generation error: ' . $e->getMessage());
            return null;
        }
    }
}
