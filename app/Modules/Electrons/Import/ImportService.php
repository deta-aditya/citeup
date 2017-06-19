<?php

namespace App\Modules\Electrons\Import;

use App\Modules\Models\Attempt;
use App\Modules\Nucleons\Service;
use App\Modules\Electrons\Storage\StorageService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

class ImportService extends Service
{
    /**
     * A storage service instance.
     *
     * @var StorageService
     */
    protected $storage;

    /**
     * Create a new service instance.
     *
     * @param  StorageService  $storage
     * @return void
     */
    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Import data to the application by given type.
     * 
     * @param  UploadedFile  $file
     * @param  string        $type
     * @return this
     */
    public function importData(UploadedFile $file, $type)
    {
        $path = $this->upload($file);

        $results = $this->loadResult($path);

        $funcname = 'evaluate' . title_case($type) . 'Data';

        $this->{$funcname}($results);

        return $this;
    }

    /**
     * 
     */
    public function evaluateScoreData($results)
    {
        $results = $results->sortByDesc('score');

        $magicNumber = 4;

        $attemptIds = $results->pluck('attempt_id');

        $attempts = Attempt::with('entry')->whereIn('id', $attemptIds)->get();

        $passed = $attempts->map(function ($item, $key) {
            return $key > $magicNumber;
        });

        //
    }

    /**
     * Upload the imported file and get the untrailed path.
     *
     * @param  UploadedFile  $file
     * @return string
     */
    protected function upload(UploadedFile $file)
    {
        $path = $this->storage->upload([
            'object_id'   => Carbon::now()->timestamp,
            'object_type' => 'imports',
            'file'        => $file,
        ]);

        return $this->makeAccessible($path);
    }

    protected function loadResult($path)
    {
        return Excel::load($path)->get();
    }

    protected function makeAccessible($path)
    {
        return 'storage/app/public/' . $this->storage->eraseTrailing($path);
    }
}
