<?php

namespace App\Http\Controllers;

use App\Services\ImageKitService;
use Illuminate\Http\Request;

class ImageTestController extends Controller
{
    private $imageKitService;

    public function __construct(ImageKitService $imageKitService)
    {
        $this->imageKitService = $imageKitService;
    }

    public function showUploadForm()
    {
        return view('test.upload');
    }

    public function testUpload(Request $request)
    {
        try {
            // Valider la présence et le type de fichier
            $request->validate([
                'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'image.required' => 'Veuillez sélectionner une image',
                'image.mimes' => 'Le fichier doit être une image de type : jpeg, png, jpg, gif',
                'image.max' => 'L\'image ne doit pas dépasser 2MB'
            ]);

            if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
                return response()->json(['error' => 'Image invalide ou corrompue'], 400);
            }

            $file = $request->file('image');
            
            // Log des informations du fichier
            \Log::info('Processing upload request', [
                'originalName' => $file->getClientOriginalName(),
                'mimeType' => $file->getMimeType(),
                'size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension()
            ]);

            $userId = 1; // Test user ID
            
            $imageId = $this->imageKitService->uploadImage($file, $userId);
            
            if (!$imageId) {
                \Log::error('Upload failed - no image ID returned');
                return response()->json(['error' => 'Échec de l\'upload sur ImageKit - aucun ID retourné'], 500);
            }

            $imageUrl = $this->imageKitService->getImageUrl($imageId);
            
            if (!$imageUrl) {
                \Log::error('Failed to generate image URL', ['imageId' => $imageId]);
                return response()->json(['error' => 'Échec de la génération de l\'URL de l\'image'], 500);
            }

            return response()->json([
                'success' => true,
                'image_id' => $imageId,
                'image_url' => $imageUrl,
                'message' => 'Image uploadée avec succès'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()['image'][0]], 400);
        } catch (\Exception $e) {
            \Log::error('Upload error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['error' => 'Une erreur est survenue lors de l\'upload: ' . $e->getMessage()], 500);
        }
    }

    public function showImages()
    {
        try {
            // Utiliser le service ImageKit existant
            $imageKit = new \ImageKit\ImageKit(
                config('services.imagekit.public_key'),
                config('services.imagekit.private_key'),
                config('services.imagekit.endpoint_url')
            );
            
            \Log::info('Fetching images from ImageKit');
            
            // Récupérer la liste des fichiers du dossier profile-pictures
            $files = $imageKit->listFiles([
                'path' => '/profile-pictures',
                'limit' => 100,
                'sort' => 'DESC_CREATED'
            ]);

            \Log::info('Files response:', ['response' => json_encode($files)]);

            if (!isset($files->result)) {
                \Log::warning('No files found in response');
                return view('test.images', ['images' => []]);
            }

            $images = collect($files->result)->map(function($file) {
                return (object)[
                    'fileId' => $file->fileId ?? 'N/A',
                    'name' => $file->name ?? 'Sans nom',
                    'url' => $file->url ?? '',
                    'createdAt' => isset($file->createdAt) ? date('Y-m-d H:i', strtotime($file->createdAt)) : 'Date inconnue'
                ];
            });

            \Log::info('Processed images:', ['count' => $images->count()]);

            return view('test.images', ['images' => $images]);
        } catch (\Exception $e) {
            \Log::error('Error fetching images: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('test.images', ['images' => []])->with('error', 'Erreur lors de la récupération des images : ' . $e->getMessage());
        }
    }
}
