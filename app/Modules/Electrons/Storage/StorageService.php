<?php

namespace App\Modules\Electrons\Storage;

use App\Modules\Nucleons\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StorageService extends Service
{
    /**
     * The trailing path to the storage.
     *
     * @var User
     */
    protected $trailing = 'storage';

    /**
     * Upload a file and return the link.
     *
     * @param  array  $params
     * @return string
     */
    public function upload(array $params)
    {
        $link = $this->putOnStorage(
            $params['object_id'], $params['object_type'], $params['file']
        );

        return $this->putTrailing($link);
    }

    /**
     * Remove a file under specified link.
     *
     * @param  string  $link
     * @return this
     */
    public function remove($link)
    {
        $link = $this->eraseTrailing($link);

        $this->removeFromStorage($link);

        return $this;
    }

    /**
     * Put the trailing path to the link.
     *
     * @param  string  $link
     * @return string  
     */
    public function putTrailing($link)
    {
        return $this->trailing . '/' . $link;
    }

    /**
     * Erase the trailing path from the link.
     *
     * @param  string  $link
     * @return string  
     */
    public function eraseTrailing($link)
    {
        return implode('/', array_slice(explode('/', $link), 1));
    }

    /**
     * Put the file on the storage and return its link.
     *
     * @param  int           $objectId
     * @param  string        $objectType
     * @param  UploadedFile  $file
     * @return User
     */
    protected function putOnStorage($objectId, $objectType, UploadedFile $file)
    {
        $directory = $this->detectMime($file) . '/' . str_plural($objectType) . '/' . $objectId;

        if (! Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        return $file->store($directory, 'public');
    }

    /**
     * Delete a file from storage under specified path.
     *
     * @param  string  $path
     * @return void
     */
    protected function removeFromStorage($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    /**
     * Get the directory based the mimetype of file.
     *
     * @param  UploadedFile  $file
     * @return string  
     */
    public function detectMime(UploadedFile $file)
    {
        switch (File::mimeType($file->path())) {
            case 'image/jpeg': case 'image/jpg': case 'image/png': case 'image/gif':
                return 'images';
        }
    }
}
