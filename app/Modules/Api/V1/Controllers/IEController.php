<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Electrons\Import\ImportService;
use App\Modules\Electrons\Export\ExportService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\IE\ImportRequest;
use App\Modules\Api\V1\Requests\IE\ExportRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IEController extends Controller
{
    use JsonApiController;
    
    /**
     * Import data to the application.
     *
     * @param  Import         $import
     * @param  ImportService  $service
     * @return Response
     */
    public function import(ImportRequest $request, ImportService $service)
    {
        // $service->importData($request->file('file'), $request->input('type'));

        return $this->respondJson([]);
    }

    /**
     * Export data from the application.
     *
     * @param  ExportRequest  $request
     * @param  ExportService  $service
     * @return Response
     */
    public function export(ExportRequest $request, ExportService $service)
    {
        $paths = $service->exportData($request->input('scopes'));

        return $this->respondJson(['paths' => $paths]);
    }
}
