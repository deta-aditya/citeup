<?php

namespace App\Modules\Electrons\ContactPeople;

use App\Modules\Models\ContactPerson;
use App\Modules\Nucleons\Service;

class ContactPersonService extends Service
{
    /**
     * The main model for the service.
     *
     * @var ContactPerson
     */
    protected $model = ContactPerson::class;

    /**
     * Get multiple contacts with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function multiple(array $params = [])
    {
        return $this->parseQueryString($this->getModel()->query(), $params)->get();
    }

    /**
     * Create a new contact and return it.
     *
     * @param  array  $data
     * @return ContactPerson
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $contact = ContactPerson::create($cleaned);

        return $contact;
    }

    /**
     * Update a contact with new data.
     *
     * @param  ContactPerson  $contact
     * @param  array          $data
     * @return this
     */
    public function update(ContactPerson $contact, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $contact->{$field} = $value;
        }

        $contact->save();

        return $this;
    }

    /**
     * Remove a contact from the database.
     *
     * @param  ContactPerson  $contact
     * @return this
     */
    public function remove(ContactPerson $contact)
    {
        $contact->delete();

        return $this;
    }
}
