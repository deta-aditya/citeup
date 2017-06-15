<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Document;
use App\Modules\Electrons\Documents\DocumentService;
use App\Modules\Api\V1\Requests\Documents\DocumentIndexRequest;
use App\Modules\Api\V1\Requests\Documents\DocumentInsertRequest;
use App\Modules\Api\V1\Requests\Documents\DocumentUpdateRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    use JsonApiController;

    /**
     * A document service instance.
     *
     * @var DocumentService
     */
    protected $documents;

    /**
     * Create a new controller instance.
     *
     * @param  DocumentService  $documents
     * @return void
     */
    public function __construct(DocumentService $documents)
    {
        $this->documents = $documents;
    }

    /**
     * Get an array of documents data.
     *
     * @param  DocumentIndexRequest  $request
     * @return Response
     */
    public function index(DocumentIndexRequest $request)
    {
        return $this->respondJson(
            ['documents' => $this->documents->getMultiple($request->all())]
        );
    }

    /**
     * Get a document data.
     *
     * @param  Request   $request
     * @param  Document  $document
     * @return Response
     */
    public function show(Request $request, Document $document)
    {
        return $this->respondJson(['document' => $document]);   
    }

    /**
     * Insert a new document data.
     *
     * @param  DocumentInsertRequest  $request
     * @return Response
     */
    public function insert(DocumentInsertRequest $request)
    {
        $document = $this->documents->create($request->all());

        return $this->respondJson(['document' => $document]);
    }

    /**
     * Update a document data.
     *
     * @param  DocumentUpdateRequest  $request
     * @param  Document               $document
     * @return Response
     */
    public function update(DocumentUpdateRequest $request, Document $document)
    {
        $this->documents->update($document, $request->all());

        return $this->respondJson(['document' => $document]);
    }

    /**
     * Delete a document data.
     *
     * @param  Request   $request
     * @param  Document  $document
     * @return Response
     */
    public function remove(Request $request, Document $document)
    {
        $this->documents->remove($document);

        return $this->respondJson(['document' => $document]);
    }
}
