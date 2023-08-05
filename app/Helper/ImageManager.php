<?php 
namespace app\Helper;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait ImageManager{
    public function uploads($file)
    {
        if($file) {
            $currentTime = now()->format('H:i:s');
            $currentTime = str_replace(':','_',$currentTime);
            $fileName   = $currentTime .' '. $file->getClientOriginalName();
            Storage::putFileAs('images', $file, $fileName);
            return $file = [
                'fileName' => $fileName,
            ];
        }
    }
    public function deleteImage($fileName){
        Storage::delete('images/'.$fileName);
    }
}