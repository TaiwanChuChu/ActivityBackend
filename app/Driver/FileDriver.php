<?php
namespace App\Driver;

use App\Models\FileStorage;
use Illuminate\Support\Facades\File;

class FileDriver
{
    public function storage($files, string $ModelType, string $ModelKey, array $options = array())
    {
        $path   = $options['path'] ?: '';
        $token  = $options['token'] ?: '';
        $single = $options['single'] ? true : false;

        $file_hash_name = \Str::random(60);
        $storage_path   = storage_path("app/public/{$path}/");

        $err = array();

        if (!$files->getMimeType()) {
            $err[] = "{$files->getClientOriginalName()}檔案格式不允許上傳";
        }

        $file_list = array(
            'file_storage_type' => $ModelType,
            'file_storage_id'   => $ModelKey,
            'name'              => $files->getClientOriginalName(),
            'size'              => $files->getSize(),
            'path'              => $storage_path,
            'mime_type'         => $files->getMimeType(),
            'extension'         => $files->extension(),
            'encode_name'       => $file_hash_name,
            'token'             => $token,
        );

        if ($files->move($storage_path, $file_hash_name) === false) {
            $err[] = "{$files->getClientOriginalName()}檔案上傳失敗";
        }

        if ($single) {
            $target = FileStorage::where(array(
                array('file_storage_type', '=', $ModelType),
                array('file_storage_id', '=', $ModelKey),
                array('token', '=', $token),
            ));
            if ($target->count() > 0) {
                File::delete($target->first()->path . $target->first()->encode_name);
            } else {
                FileStorage::insert($file_list);
            }
            $target->update($file_list);
        } else {
            FileStorage::insert($file_list);
        }

        return $err;
    }

    public function storageMul($files, string $ModelType, string $ModelKey, array $options = array())
    {
        $path    = $options['path'] ?: '';
        $token   = $options['token'] ?: '';
        $replace = $options['replace'] ? true : false;

        $files     = is_array($files) ?: array($files);
        $file_list = array();
        $err       = array();

        foreach ($files as $f_k => $f_i) {
            $file_hash_name = \Str::random(60);
            $storage_path   = storage_path("app/public/{$path}/");

            if (!$f_i->getMimeType()) {
                $err[$f_k] = "{$f_i->getClientOriginalName()}檔案格式不允許上傳";
            }

            $file_list[$f_k] = array(
                'file_storage_type' => $ModelType,
                'file_storage_id'   => $ModelKey,
                'name'              => $f_i->getClientOriginalName(),
                'size'              => $f_i->getSize(),
                'path'              => $storage_path,
                'mime_type'         => $f_i->getMimeType(),
                'extension'         => $f_i->extension(),
                'encode_name'       => $file_hash_name,
                'token'             => $token,
            );

            if ($f_i->move($storage_path, $file_hash_name) === false) {
                $files[$f_k] = array();
                $err[$f_k]   = "{$f_i->getClientOriginalName()}檔案上傳失敗";
            }
        }

        FileStorage::insert(\collect($file_list)->chunk(100)->toArray()[0]);
        return $err;
    }

    public function renderFile(string $encode_name)
    {
        $file = FileStorage::where('encode_name', '=', $encode_name)->first();

        if (!$file) {
            abort(404);
        }

        $headers = array(
            'Content-Length' => $file->size,
            'Content-Type'   => $file->mime_type,
        );

        $fileInstance = $file->path . $file->encode_name;

        return response()->file($fileInstance, $headers);
    }
}
