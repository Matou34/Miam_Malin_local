<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;

class FileUploader
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function uploadFile(File $file): string
    {

        $fileName = $file->getClientOriginalName();

        // Path to directory where file is stored (outside public folder)
        $storagePath = $this->params->get('kernel.project_dir') . '/public/recettes_images';

        // Check if the directory exists, if not create it
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        $file->move($storagePath, $fileName);

        return $fileName;
    }

    public function removeFile(string $file): void
    {
        unlink($this->params->get('kernel.project_dir') . '/public/recettes_images/' .$file);
    }
}
