<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilisateur extends Model
{
    protected $table = 'utilisateur';
    protected $guarded = ["idUtilisateur"];
    protected $primaryKey = "idUtilisateur";
    protected $fillable = ['pseudo', 'image_id'];
    public $timestamps = false;

    public function crypto():BelongsTo{
        return $this->belongsTo(Crypto::class, "idCrypto","idCrypto");
    }

    // public function getProfileImageUrl()
    // {
    //     if (!$this->image_id) {
    //         return null;
    //     }
        
    //     $imageKitService = app(ImageKitService::class);
    //     return $imageKitService->getImageUrl($this->image_id);
    // }
}
