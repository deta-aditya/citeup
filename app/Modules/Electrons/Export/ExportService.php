<?php

namespace App\Modules\Electrons\Export;

use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Nucleons\Service;
use App\Modules\Models\Answer;

class ExportService extends Service
{
    protected $defaultType = 'csv';

    /**
     * Export data from the application and returns the path.
     * 
     * @param  array  $scopes
     * @return array
     */
    public function exportData(array $scopes)
    {
        $paths = [];

        foreach ($scopes as $scope) {
            array_push(
                $paths, $this->slicePath(
                    $this->createAndExport($scope, $this->defaultType)['full']
                )
            );
        }

        return $paths;
    }

    /**
     * Create and export (store) data of the given scope and filetype.
     *
     * @param  string  $scope
     * @param  string  $fileType
     * @return array
     */
    public function createAndExport($scope, $filetype)
    {
        return Excel::create($scope, function ($excel) use ($scope) {

            $excel->sheet('Sheet1', function ($sheet) use ($scope) {

                $funcname = 'get' . title_case($scope) . 'Data';

                $sheet->fromArray($this->{$funcname}());

            });

        })->store($filetype);
    }

    /**
     * Get the answers scope data.
     *
     * @return array
     */
    public function getAnswersData()
    {
        return Answer::select('id', 'attempt_id', 'choice_id')->get();
    }

    /**
     * Slice the storage path so it is accessible via URL.
     *
     * @param  string  $path
     * @return string
     */
    protected function slicePath($path)
    {
        return 'storage/'. implode('/', array_slice(explode('/', $path), 2));
    }
}
