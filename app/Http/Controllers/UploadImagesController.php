<?php

namespace App\Http\Controllers;

use App\Services\UploadImageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadImagesController extends Controller
{
    public function uploadImage($request, $params, $directory, $fieldName){
        $uploadImageService = new UploadImageService();
        if ($request->has($fieldName)) {
            $file = $request->file($fieldName);
            $imageResponse = $uploadImageService->create($file, $directory);
            if ($imageResponse['success']) {
                //if file already exists, deletes it
                if ($params[$fieldName] != "") {
                    Storage::disk('public')->delete($params[$fieldName]);
                }
                $params[$fieldName] = $imageResponse["path"];
            }else {
                throw new Exception("Error al guardar la imagen");
            }
        }
        return $params;
    }

    public function uploadMultipleImages($request, $model, $service, $directory){
        $uploadImageService = new UploadImageService();

        if($request->has('images')){
            $files = $request->file('images');
            $imageResponse = $uploadImageService->createMultiple($files,$model["id"],$directory);

            if(count($imageResponse)> 0){
                $arrayImages = array_column($imageResponse,"path");
                $newElements = $service->createFast($model["id"],$arrayImages);
                return $newElements;
            }else{
                throw new Exception("Error al guardar las imagen");
            }
        }
    }
}
