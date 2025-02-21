<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFile
{
    
    public function __construct(private readonly SluggerInterface $slugger) {
    }
    
    public function upload(UploadedFile $file, String $name, String $dest): String
    {
        
        $name = $this->slugger->slug($name) . '-' . uniqid() . $file->guessExtension();
        $file->move($dest, $name);
        return $name; 
        
    }

}