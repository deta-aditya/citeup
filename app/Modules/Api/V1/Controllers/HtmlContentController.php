<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\HtmlContent;
use App\Modules\Electrons\Edits\EditService;
use App\Modules\Electrons\HtmlContents\HtmlContentService;
use App\Modules\Api\V1\Requests\Edits\EditIndexRequest;
use App\Modules\Api\V1\Requests\HtmlContents\HtmlContentIndexRequest;
use App\Modules\Api\V1\Requests\HtmlContents\HtmlContentShowRequest;
use App\Modules\Api\V1\Requests\HtmlContents\HtmlContentInsertRequest;
use App\Modules\Api\V1\Requests\HtmlContents\HtmlContentUpdateRequest;
use App\Modules\Api\V1\Requests\HtmlContents\HtmlContentDeleteRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HtmlContentController extends Controller
{
    use JsonApiController;

    /**
     * A html content service instance.
     *
     * @var HtmlContentService
     */
    protected $contents;

    /**
     * Create a new controller instance.
     *
     * @param  HtmlContentService  $contents
     * @return void
     */
    public function __construct(HtmlContentService $contents)
    {
        $this->contents = $contents;
    }

    /**
     * Get an array of contents data.
     *
     * @param  HtmlContentIndexRequest  $request
     * @return Response
     */
    public function index(HtmlContentIndexRequest $request)
    {
        return $this->respondJson(
            ['html_contents' => $this->contents->multiple($request->all())]
        );
    }

    /**
     * Get a content data.
     *
     * @param  HtmlContentShowRequest   $request
     * @param  HtmlContent   $content
     * @return Response
     */
    public function show(HtmlContentShowRequest $request, HtmlContent $content)
    {
        return $this->respondJson(['html_content' => $content]);   
    }

    /**
     * Insert a new content data.
     *
     * @param  HtmlContentInsertRequest  $request
     * @return Response
     */
    public function insert(HtmlContentInsertRequest $request)
    {
        $content = $this->contents->create($request->all());

        return $this->respondJson(['html_content' => $content]);
    }

    /**
     * Update a content data.
     *
     * @param  HtmlContentUpdateRequest  $request
     * @param  HtmlContent               $content
     * @return Response
     */
    public function update(HtmlContentUpdateRequest $request, HtmlContent $content)
    {
        $this->contents->update($content, $request->all());

        return $this->respondJson(['html_content' => $content]);
    }

    /**
     * Delete a content data.
     *
     * @param  HtmlContentDeleteRequest   $request
     * @param  HtmlContent   $content
     * @return Response
     */
    public function remove(HtmlContentDeleteRequest $request, HtmlContent $content)
    {   
        $this->contents->remove($content);

        return $this->respondJson(['html_content' => $content]);
    }

    /**
     * Get edits of the given content.
     *
     * @param  EditIndexRequest   $request
     * @param  HtmlContent            $content
     * @param  EditService        $edits
     * @return Response
     */
    public function edits(EditIndexRequest $request, HtmlContent $content, EditService $edits)
    {
        $queries = $request->all();

        $queries['html_content'] = $content->id;

        return $this->respondJson(
            ['edits' => $edits->getMultiple($queries)]
        );
    }
}
