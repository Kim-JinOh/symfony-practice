<?php

namespace App\FileService\Interfaces;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderInterface
{
    public function upload(UploadedFile $file, string $path);

    public function delete(string $path);

    public function download(string $path);
}