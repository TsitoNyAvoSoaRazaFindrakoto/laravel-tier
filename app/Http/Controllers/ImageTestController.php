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

            //Ty le sary ty
            $imageUrl = $this->imageKitService->getImageUrl($imageId);

            $user = \App\Models\Utilisateur::find($userId);
            
            // Si l'utilisateur n'existe pas, on le crée
            if (!$user) {
                $user = new \App\Models\Utilisateur();
                $user->idUtilisateur = $userId;
                $user->pseudo = "User_" . $userId; // Pseudo par défaut
            } else if ($user->image_id) {
                // Si l'utilisateur existe et a déjà une image, on la supprime
                $this->imageKitService->deleteImage($user->image_id);
            }

            $user->image_id = $imageId;
            $user->save();

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
            $userId = auth()->id();
            $userId = 1;
            $user = \App\Models\Utilisateur::find($userId);

            if (!$user || !$user->image_id) {
                return response()->json([
                    'success' => true,
                    'message' => 'Aucune photo de profil',
                    'image' => null
                ]);
            }

            $imageUrl = $this->imageKitService->getImageUrl($user->image_id);

            if (!$imageUrl) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la récupération de l\'URL de l\'image',
                    'image' => null
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Photo de profil récupérée avec succès',
                'image' => [
                    'id' => $user->image_id,
                    'url' => $imageUrl
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching user profile image: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération de la photo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
