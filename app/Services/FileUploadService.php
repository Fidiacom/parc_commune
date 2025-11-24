<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Upload a file and return the file path.
     */
    public function uploadFile(UploadedFile $file, string $path): string
    {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = str_replace(['\\', '/', ':', '*', '"', "'", ">", "<", "|", '?', '؟', '.', ' ', '-'], '_', $fileName);
        $fileName = $fileName . date("_d_m_Y_G_i_s");
        $fileExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $fullName = $fileName . '.' . $fileExtension;
        
        $file->storeAs('public/uloaded_files/' . $path, $fullName);
        
        return 'storage/uloaded_files/' . $path . '/' . $fullName;
    }

    /**
     * Delete a file from storage.
     */
    public function deleteFile(string $filePath): bool
    {
        $storagePath = str_replace('storage/', 'public/', $filePath);
        
        if (Storage::exists($storagePath)) {
            return Storage::delete($storagePath);
        }
        
        return false;
    }

    /**
     * Get file information.
     */
    public function getFileInfo(UploadedFile $file): array
    {
        return [
            'name' => $file->getClientOriginalName(),
            'type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ];
    }
}



