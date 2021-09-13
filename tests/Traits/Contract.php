<?php

namespace Tests\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait Contract
{
    public function uploadFile()
    {
        $fileName = "contract.xlsx";
        $storage_path = Storage::disk('contracts')->getDriver()->getAdapter()->getPathPrefix();
        $path = $storage_path."".$fileName;
        $mimeType = Storage::disk('contracts')->mimeType($fileName);
        $size = Storage::disk('contracts')->size($fileName);
        $file = new UploadedFile($path, $fileName, $mimeType, $size, false, true);
        
        return $this->json('POST', $this->route("/contracts/upload"), ['file' => $file]);
    }
}
