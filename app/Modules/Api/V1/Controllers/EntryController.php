<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Entry;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Activities\EntryService;
use App\Modules\Electrons\Submissions\SubmissionService;
use App\Modules\Electrons\Testimonials\TestimonialService;
use App\Modules\Electrons\Attempts\AttemptService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Entries\EntryIndexRequest;
use App\Modules\Api\V1\Requests\Entries\EntryShowRequest;
use App\Modules\Api\V1\Requests\Entries\EntryInsertRequest;
use App\Modules\Api\V1\Requests\Entries\EntryUpdateRequest;
use App\Modules\Api\V1\Requests\Entries\EntryDeleteRequest;
use App\Modules\Api\V1\Requests\Entries\EntrantQualifyRequest;
use App\Modules\Api\V1\Requests\Entries\EntrantDisqualifyRequest;
use App\Modules\Api\V1\Requests\Entries\AddSubmissionRequest;
use App\Modules\Api\V1\Requests\Entries\AddDocumentRequest;
use App\Modules\Api\V1\Requests\Entries\AddTestimonialRequest;
use App\Modules\Api\V1\Requests\Entries\StartAttemptRequest;
use App\Modules\Api\V1\Requests\Users\UpdateEntrantProfileRequest;
use App\Modules\Api\V1\Requests\Submissions\SubmissionIndexRequest;
use App\Modules\Api\V1\Requests\Documents\DocumentIndexRequest;
use App\Modules\Api\V1\Requests\Testimonials\TestimonialIndexRequest;
use App\Modules\Api\V1\Requests\Attempts\AttemptIndexRequest;
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
     * Get an array of entries data.
     *
     * @param  EntryIndexRequest  $request
     * @return Response
     */
    public function index(EntryIndexRequest $request)
    {
        return $this->respondJson(
            ['entries' => $this->entries->multiple($request->all())]
        );
    }

    /**
     * Get an entry data.
     *
     * @param  EntryShowRequest  $request
     * @param  Entry             $entry
     * @return Response
     */
    public function show(EntryShowRequest $request, Entry $entry)
    {
        $this->entries->loadRelationships($entry);

        return $this->respondJson(['entry' => $entry]);   
    }

    /**
     * Insert a new entry data.
     *
     * @param  EntryInsertRequest  $request
     * @param  RoleService        $roles
     * @param  ProfileService     $profiles
     * @param  EntryService       $entries
     * @return Response
     */
    public function insert(EntryInsertRequest $request)
    {
        $entry = $this->entries->create($request->all());

        return $this->respondJson(['entry' => $entry]);
    }

    /**
     * Update a entry data.
     *
     * @param  EntryUpdateRequest  $request
     * @param  UserService         $users
     * @param  Entry               $entry
     * @param  RoleService         $roles
     * @param  ProfileService      $profiles
     * @return Response
     */
    public function update(EntryUpdateRequest $request, UserService $users, Entry $entry)
    {
        foreach ($request->input('users') as $user) {
            $users->updateById($user['id'], $user);
        }

        $this->entries->update($entry, $request->all());

        return $this->respondJson(['entry' => $entry]);
    }

    /**
     * Actually same as above but this method receives different request. 
     * This is why we need to use service pattern.
     */
    public function updateEntrantProfile(UpdateEntrantProfileRequest $request, UserService $users, Entry $entry)
    {
        foreach ($request->input('users') as $user) {
            $users->updateById($user['id'], $user);
        }

        $this->entries->update($entry, $request->all());

        return $this->respondJson(['entry' => $entry]);
    }

    /**
     * Disqualify entrant.
     */
    public function disqualify(EntrantDisqualifyRequest $request, Entry $entry)
    {
        $this->entries->changeStatus($entry->id, EntryService::STATUS_SUSPENDED);

        return $this->respondJson(['entry' => $entry]);
    }

    /**
     * Qualify entrant.
     */
    public function qualify(EntrantQualifyRequest $request, Entry $entry)
    {
        $this->entries->changeStatus($entry->id, EntryService::STATUS_ACTIVE);
    }

    /**
     * Delete a entry data.
     *
     * @param  EntryDeleteRequest  $request
     * @param  Entry               $entry
     * @param  StorageService     $storages
     * @return Response
     */
    public function remove(EntryDeleteRequest $request, Entry $entry)
    {
        $this->entries->remove($entry);

        return $this->respondJson(['entry' => $entry]);
    }

    /**
     * Get the submissions of a given entry.
     *
     * @param  SubmissionIndexRequest  $request
     * @param  Entry                   $entry
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
     * @param  Entry                   $entry
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
     * Get the testimonials of a given entry.
     *
     * @param  TestimonialIndexRequest  $request
     * @param  Entry                    $entry
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
     * @param  Entry                    $entry
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

    /**
     * Get the attempts of a given entry.
     *
     * @param  AttemptIndexRequest  $request
     * @param  Entry                $entry
     * @param  AttemptService       $attempts
     * @return Response
     */
    public function attempts(AttemptIndexRequest $request, Entry $entry, AttemptService $attempts)
    {
        $queries = $request->all();

        $queries['entry'] = $entry->id;

        return $this->respondJson(
            ['attempts' => $attempts->getMultiple($queries)]
        );
    }

    /**
     * Start a new attempt to a given entry.
     *
     * @param  StartAttemptRequest  $request
     * @param  Entry                $entry
     * @param  AttemptService       $attempts
     * @return Response
     */
    public function startAttempt(StartAttemptRequest $request, Entry $entry, AttemptService $attempts)
    {
        $attempt = $attempts->start($entry->id, $request->input('started_at'));

        return $this->respondJson(['attempt' => $attempt]);
    }
}
