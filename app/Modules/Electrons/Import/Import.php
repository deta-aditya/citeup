<?php

namespace App\Modules\Electrons\Import;

use App\Modules\Electrons\Storage\StorageService;
use App\Modules\Api\V1\Requests\IE\ImportRequest;
use Maatwebsite\Excel\Files\ExcelFile;
use Carbon\Carbon;

class Import extends ExcelFile
{
    /**
     * An ImportRequest instance.
     *
     * @var ImportRequest
     */
    public $request;

    /**
     * A storage service instance.
     *
     * @var StorageService
     */
    protected $storage;

    /**
     * Create a new import instance.
     *
     * @param  ImportRequest   $request
     * @param  StorageService  $storage
     * @return void
     */
    public function __construct(ImportRequest $request, StorageService $storage)
    {
        $this->request = $request;
        $this->storage = $storage;
    }

    /**
     * Get the imported file.
     *
     * @return string
     */
    public function getFile()
    {
        $path = $this->upload();

        var_dump(storage_path($path));
        die;

        return storage_path($path);
    }

    /**
     * Upload the imported file and get the untrailed path.
     *
     * @return string
     */
    protected function upload()
    {
        $path = $this->storage->upload([
            'object_id'   => Carbon::now()->timestamp,
            'object_type' => 'imports',
            'file'        => $this->request->file('file'),
        ]);

        return $this->storage->eraseTrailing($path);
    }
}
