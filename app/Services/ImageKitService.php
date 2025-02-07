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
        try {
            if (!$file->isValid()) {
                \Log::error('Invalid file provided');
                return null;
            }

            $originalName = $file->getClientOriginalName();
            $cleanName = preg_replace('/[^a-zA-Z0-9.]/', '_', $originalName);
            $fileName = "profil_{$userId}_{$cleanName}";
            
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
                'file' => base64_encode($fileContent),
                'fileName' => $fileName,
                'folder' => '/profile-pictures',
                'useUniqueFileName' => false
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
            
            // Récupérer les détails du fichier d'abord
            $fileDetails = $this->imageKit->getFileDetails($fileId);
            
            if (!isset($fileDetails->result) || !isset($fileDetails->result->url)) {
                \Log::error('Failed to get file details from ImageKit', [
                    'fileId' => $fileId,
                    'response' => json_encode($fileDetails)
                ]);
                return null;
            }

            return $fileDetails->result->url;
            
        } catch (\Exception $e) {
            \Log::error('ImageKit URL generation error: ' . $e->getMessage(), [
                'fileId' => $fileId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function deleteImage($fileId)
    {
        if (!$fileId) {
            \Log::warning('Attempt to delete image with null fileId');
            return false;
        }

        try {
            \Log::info('Attempting to delete image from ImageKit', ['fileId' => $fileId]);

            $response = $this->imageKit->deleteFile($fileId);

            if (isset($response->result) && $response->result) {
                \Log::info('Image deleted successfully from ImageKit', ['fileId' => $fileId]);
                return true;
            }

            \Log::error('ImageKit delete failed', [
                'fileId' => $fileId,
                'response' => json_encode($response)
            ]);
            return false;

        } catch (\Exception $e) {
            \Log::error('ImageKit delete error: ' . $e->getMessage(), [
                'fileId' => $fileId,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }
}
