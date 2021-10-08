<?php

namespace App\Services;

use App\Models\Homework;
use Image;
use Exception;
use Illuminate\Support\Facades\Storage;

class UploadImageService
{
    public function create($file, $type){
        // GET FILME NAME WITH EXTENSION
        $fileNameWithExt = $file->getClientOriginalName();

        // GET FILE PATH
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

        // REMOVE UNWANTED CHARACTERS
        $fileName = preg_replace("/[^A-Za-z0-9 ]/", '', $fileName);
        $fileName = preg_replace("/\s+/", '-', $fileName);

        // GET ORIGINAL IMG EXTENSION
        $extension = $file->getClientOriginalExtension();

        // CREATE UNIQUE FILE NAME
        $fileNameToStore = "{$type}/".uniqid().'.'.$extension;

        //RESIZE IMG
        return $this->resizeImage($file, $fileNameToStore);
    }

    public function resizeImage($file, $fileNameToStore){
        // RESIZE IMG
        $resize = Image::make($file)->resize(600, null, function ($constraint){
            $constraint->aspectRatio();
        })->encode('jpg');

        // CREATE HASH VALUE
        $hash = md5($resize->_toString());

        //PREPARE QUALIFY IMAGE NAME
        $image = $hash."jpg";
        $fullPath = "$fileNameToStore";

        //PUT IMG TO STORAGE
        $save = Storage::disk('public')->put($fullPath, $resize->_toString());
        if ($save) {
            return ["success" => true, "path" => $fullPath];
        }
        return ["success" => false, "path" => ""];
    }

    public function createMultiple($files,$id,$type){  
        $arrayResult=[];
        foreach ($files as $file) {
           $arrayResult[] = $this->create($file,$id,$type);
        }
        return $arrayResult;
    }

    public function createHWFile($file, $type, $homeworkID){
        $homework = Homework::findOrFail($homeworkID);
        $workingTitle = str_replace(' ', '_', $homework->title);
        $originalName = substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), "."));
        $originalName = str_replace(' ', '_', $originalName);
        // GET ORIGINAL IMG EXTENSION
        $extension = $file->getClientOriginalExtension();
        // CREATE UNIQUE FILE NAME
        $fileNameToStore = "{$type}/".$workingTitle.'_'.$originalName.'.'.$extension;
        //PUT IMG TO STORAGE
        $save = Storage::disk('s3')->put($fileNameToStore, fopen($file, 'r+'));

        if ($save) {
            return ["success" => true, "path" => $fileNameToStore];
        }
        return ["success" => false, "path" => ""];
    }
}