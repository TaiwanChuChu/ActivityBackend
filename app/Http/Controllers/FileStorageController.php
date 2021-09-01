<?php

namespace App\Http\Controllers;

use App\Driver\FileDriver;
use App\Models\FileStorage;
use Illuminate\Http\Request;

class FileStorageController extends Controller
{
    public function __construct(FileDriver $fileDriver)
    {
        $this->fileDriver = $fileDriver;
    }

    // TODO: 修改成call FileDriver的storage
    public function store(Request $request) {
        if($request->hasFile('file') === false) {
            return response()->json(['message' => '未提供欲上傳檔案'], 400);
        }
        
        $files = [];
        $file = is_array($request->file('file')) ?: [$request->file('file')];

        foreach($file as $f_k => $f_i) {
            if(!$f_i->getMimeType()) {
                $response[$f_k] = "{$f_i->getFilename()}檔案格式不允許上傳";
            }
        }


        try {
            $result = FileStorage::insert($files);
        } catch(\Exception $exception) {
            return response()->json(['message' => '檔案上傳失敗!'], 400);
        }
    }

    public function renderFile($encode_name) {
        return $this->fileDriver->renderFile($encode_name);
    }
}
