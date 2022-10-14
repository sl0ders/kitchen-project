<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $backgroundDirectory;
    private $slugger;
    private $pictureDirectory;

    public function __construct($backgroundDirectory, SluggerInterface $slugger, $pictureDirectory)
    {
        $this->backgroundDirectory = $backgroundDirectory;
        $this->slugger = $slugger;
        $this->pictureDirectory = $pictureDirectory;
    }

    public function upload(UploadedFile $file, string $type): array
    {
        $directory = "";
        if ($type == "background") {
            $directory = $this->getBackgroundDirectory();
        } elseif ($type == "picture") {
            $directory = $this->getPictureDirectory();
        }
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        $filePath = $directory ."/". $fileName;
        $extention = $file->guessExtension();
        try {
                $file->move($directory, $fileName);
        } catch (FileException $e) {
            dd($e);
        }

        return [$fileName,$filePath,$extention];
    }

    public function getBackgroundDirectory()
    {
        return $this->backgroundDirectory;
    }

    public function getPictureDirectory()
    {
        return $this->pictureDirectory;
    }
}