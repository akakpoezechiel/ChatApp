<?php
namespace App\Interfaces;

interface FileInterface
{
    public function getAllFiles();

    public function store(array $data);

    public function getFileById($id);

    public function createFile(array $data);

    public function updateFile($id, array $data);

    public function deleteFile($id);

    public function destroy($data);

}

