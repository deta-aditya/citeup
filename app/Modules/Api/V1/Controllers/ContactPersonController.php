<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\ContactPerson;
use App\Modules\Electrons\ContactPeople\ContactPersonService;
use App\Modules\Api\V1\Requests\Edits\EditIndexRequest;
use App\Modules\Api\V1\Requests\ContactPeople\ContactPersonIndexRequest;
use App\Modules\Api\V1\Requests\ContactPeople\ContactPersonShowRequest;
use App\Modules\Api\V1\Requests\ContactPeople\ContactPersonInsertRequest;
use App\Modules\Api\V1\Requests\ContactPeople\ContactPersonUpdateRequest;
use App\Modules\Api\V1\Requests\ContactPeople\ContactPersonDeleteRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactPersonController extends Controller
{
    use JsonApiController;

    /**
     * A contact service instance.
     *
     * @var ContactPersonService
     */
    protected $contacts;

    /**
     * Create a new controller instance.
     *
     * @param  ContactPersonService  $contacts
     * @return void
     */
    public function __construct(ContactPersonService $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Get an array of contacts data.
     *
     * @param  ContactPersonIndexRequest  $request
     * @return Response
     */
    public function index(ContactPersonIndexRequest $request)
    {
        return $this->respondJson(
            ['contact_people' => $this->contacts->multiple($request->all())]
        );
    }

    /**
     * Get a contact data.
     *
     * @param  ContactPersonShowRequest   $request
     * @param  ContactPerson              $contact
     * @return Response
     */
    public function show(ContactPersonShowRequest $request, ContactPerson $contact)
    {
        return $this->respondJson(['contact_person' => $contact]);   
    }

    /**
     * Insert a new contact data.
     *
     * @param  ContactPersonInsertRequest  $request
     * @return Response
     */
    public function insert(ContactPersonInsertRequest $request)
    {
        $contact = $this->contacts->create($request->all());

        return $this->respondJson(['contact_person' => $contact]);
    }

    /**
     * Update a contact data.
     *
     * @param  ContactPersonUpdateRequest  $request
     * @param  ContactPerson               $contact
     * @return Response
     */
    public function update(ContactPersonUpdateRequest $request, ContactPerson $contact)
    {
        $this->contacts->update($contact, $request->all());

        return $this->respondJson(['contact_person' => $contact]);
    }

    /**
     * Delete a contact data.
     *
     * @param  ContactPersonDeleteRequest   $request
     * @param  ContactPerson                $contact
     * @return Response
     */
    public function remove(ContactPersonDeleteRequest $request, ContactPerson $contact)
    {
        $this->contacts->remove($contact);

        return $this->respondJson(['contact_person' => $contact]);
    }
}
