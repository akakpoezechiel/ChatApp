<?php

namespace App\Repositories;

use App\Interfaces\FileInterface;
use App\Models\File;
// use App\Repositories\Interfaces\FileInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;

class FileRepository implements FileInterface
{

    public function store(array $data)
    {
        // return File::createFile($data);
        return File::create($data);
    }
    public function getAllFiles()
    {
        return File::all();
    }

    public function getFileById($id)
    {
        return File::findOrFail($id);
    }

    public function createFile(array $data)
    {
        return File::create($data);
    }

    public function updateFile($id, array $data)
    {
        $file = File::findOrFail($id);
        $file->update($data);
        return $file;
    }

    public function deleteFile($id)
    {
        $file = File::findOrFail($id);
        return $file->delete();
    }

    public function destroy($data)
    {
        return File::where('id', $data);
    }
}
