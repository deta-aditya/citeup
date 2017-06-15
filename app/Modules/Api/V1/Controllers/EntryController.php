<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Entry;
use App\Modules\Electrons\Activities\EntryService;
use App\Modules\Electrons\Submissions\SubmissionService;
use App\Modules\Electrons\Documents\DocumentService;
use App\Modules\Electrons\Testimonials\TestimonialService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Entries\EntryModifyRequest;
use App\Modules\Api\V1\Requests\Entries\AddSubmissionRequest;
use App\Modules\Api\V1\Requests\Entries\AddDocumentRequest;
use App\Modules\Api\V1\Requests\Entries\AddTestimonialRequest;
use App\Modules\Api\V1\Requests\Submissions\SubmissionIndexRequest;
use App\Modules\Api\V1\Requests\Documents\DocumentIndexRequest;
use App\Modules\Api\V1\Requests\Testimonials\TestimonialIndexRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    use JsonApiController;

    /**
     * A entry service instance.
     *
     * @var EntryService
     */
    protected $entries;

    /**
     * Create a new controller instance.
     *
     * @param  EntryService  $entries
     * @return void
     */
    public function __construct(EntryService $entries)
    {
        $this->entries = $entries;
    }

    /**
     * Modify stage and status of an entry data.
     *
     * @param  EntryModifyRequest  $request
     * @param  Entry               $entry
     * @return Response
     */
    public function modify(EntryModifyRequest $request, Entry $entry)
    {
        $this->entries->modifyStage($entry, $request->input('stage', null))
                      ->modifyStatus($entry, $request->input('status', null));

        return $this->respondJson(['entry' => $entry]);
    }

    /**
     * Get the submissions of a given entry.
     *
     * @param  SubmissionIndexRequest  $request
     * @param  Entry                   $Entry
     * @param  SubmissionService       $submissions
     * @return Response
     */
    public function submissions(SubmissionIndexRequest $request, Entry $entry, SubmissionService $submissions)
    {
        $queries = $request->all();

        $queries['entry'] = $entry->id;

        return $this->respondJson(
            ['submissions' => $submissions->getMultiple($queries)]
        );
    }

    /**
     * Add a new submission to a given entry.
     *
     * @param  AddSubmissionRequest    $request
     * @param  Entry                   $Entry
     * @param  SubmissionService       $submissions
     * @return Response
     */
    public function addSubmission(AddSubmissionRequest $request, Entry $entry, SubmissionService $submissions)
    {
        $data = $request->all();

        $data['entry'] = $entry->id;

        $submission = $submissions->create($data);

        return $this->respondJson(['submission' => $submission]);
    }

    /**
     * Get the documents of a given entry.
     *
     * @param  DocumentIndexRequest  $request
     * @param  Entry                   $Entry
     * @param  DocumentService       $documents
     * @return Response
     */
    public function documents(DocumentIndexRequest $request, Entry $entry, DocumentService $documents)
    {
        $queries = $request->all();

        $queries['entry'] = $entry->id;

        return $this->respondJson(
            ['documents' => $documents->getMultiple($queries)]
        );
    }

    /**
     * Add a new document to a given entry.
     *
     * @param  AddDocumentRequest    $request
     * @param  Entry                   $Entry
     * @param  DocumentService       $documents
     * @return Response
     */
    public function addDocument(AddDocumentRequest $request, Entry $entry, DocumentService $documents)
    {
        $data = $request->all();

        $data['entry'] = $entry->id;

        $document = $documents->create($data);

        return $this->respondJson(['document' => $document]);
    }

    /**
     * Get the testimonials of a given entry.
     *
     * @param  TestimonialIndexRequest  $request
     * @param  Entry                   $Entry
     * @param  TestimonialService       $testimonials
     * @return Response
     */
    public function testimonials(TestimonialIndexRequest $request, Entry $entry, TestimonialService $testimonials)
    {
        $queries = $request->all();

        $queries['entry'] = $entry->id;

        return $this->respondJson(
            ['testimonials' => $testimonials->getMultiple($queries)]
        );
    }

    /**
     * Add a new testimonial to a given entry.
     *
     * @param  AddTestimonialRequest    $request
     * @param  Entry                   $Entry
     * @param  TestimonialService       $testimonials
     * @return Response
     */
    public function addTestimonial(AddTestimonialRequest $request, Entry $entry, TestimonialService $testimonials)
    {
        $data = $request->all();

        $data['entry'] = $entry->id;

        $testimonial = $testimonials->create($data);

        return $this->respondJson(['testimonial' => $testimonial]);
    }
}
