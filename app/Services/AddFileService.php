<?php

namespace App\Services;
use Illuminate\Http\UploadedFile;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AddFileService{

    public function __construct($files)
    {
        $this->files = $files;
    }

    /**
     * Метод для перемещения файлов в указанною папку.
     *
     * @param string $folder
     * @return json
     */
    public function sendFileToFolder($folder){

        $JsonPath = array(); // array->json
        // папки где будут хранится другие папки -> feedback, works ...
        $directory = 'app/uploads/' . Auth::user()->id . '/' . $folder;
        // генерация уникального имени папки
        $unic_folder = md5(Auth::user()->id . Carbon::now('Europe/Kiev')->toDateTimeString());
        // уникальная папка для текущих файлов
        $folder_material = $directory . '/' . $unic_folder;
        // проверка на существования папки
        if(Storage::disk('public')->exists($directory)){
            Storage::disk('public')->makeDirectory($folder_material);
            // загружаем файлы
            foreach($this->files as $file){
                $fileName = $file->getClientOriginalName();
                $path = $file->storeAs($folder_material, $fileName, 'public');
                array_push($JsonPath, $path);
            }
        }else{ // папка не создана и мы ща создадим
            Storage::disk('public')->makeDirectory($directory);
            // загружаем файлы
            foreach($this->files as $file){
                $fileName = $file->getClientOriginalName();
                $path = $file->storeAs($folder_material, $fileName, 'public');
                array_push($JsonPath, $path);
            }
        }
        return $JsonPath;
    }


}
