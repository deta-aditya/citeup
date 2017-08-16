<?php

namespace App\Modules\Electrons\Activities;

use App\User;
use App\Modules\Models\Entry;
use App\Modules\Nucleons\Service;

class EntryService extends Service
{
    /**
     * The just registered stage.
     */
    const STAGE_REGISTERED_ENTRANT = 0;

    /**
     * The completed document stage.
     */
    const STAGE_COMPLETED_ENTRANT = 1;

    /**
     * The done test stage.
     */
    const STAGE_TESTED_ENTRANT = 2;

    /**
     * The finalist stage.
     */
    const STAGE_FINALIST = 3;

    /**
     * The winner stage.
     */
    const STAGE_WINNER = 4;

    /**
     * The suspended/disqualified status.
     */
    const STATUS_SUSPENDED = 0;

    /**
     * The active status.
     */
    const STATUS_ACTIVE = 1;

    /**
     * The main model for the service.
     *
     * @var Entry
     */
    protected $model = Entry::class;

    /**
     * Get multiple entries with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function multiple(array $params)
    {
        return $this->multipleCustom($this->getModel()->query(), $params);
    }

    /**
     * Get multiple entries with custom query and conditions.
     *
     * @param  Builder  $query
     * @param  array    $params
     * @return array
     */
    public function multipleCustom($query, array $params)
    {
        $query = $this->parseQueryString($query, $params);

        if (array_has($params, 'activity')) {
            $query->ofActivity((int) $params['activity']);
        }

        return $query->get();
    }

    /**
     * Load mandatory relationships of the entry.
     *
     * @param  Entry  $entry
     * @return this
     */
    public function loadRelationships(Entry $entry)
    {
        $entry->load('users', 'users.documents', 'submissions', 'attempts', 'testimonials', 'activity');

        return $this;
    }

    /**
     * Associate the given user to an entry.
     *
     * @param  User       $user
     * @param  Entry|int  $entry
     * @return this
     */
    public function associate(User $user, $entry)
    {
        if (! $entry instanceof Entry) {
            $entry = Entry::find($entry);
        }

        $entry->users()->save($user);

        return $this;
    }

    /**
     * Create a new entry and return it.
     *
     * @param  array  $data
     * @return Entry
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $cleaned['activity_id'] = $data['activity'];

        return Entry::create($cleaned);
    }

    /**
     * Update an entry with new data.
     *
     * @param  Entry  $entry
     * @param  array  $data
     * @return this
     */
    public function update(Entry $entry, array $data)
    {
        $cleaned = $this->cleanForUpdate($data);

        foreach ($cleaned as $field => $value) {
            $entry->{$field} = $value;
        }

        $entry->save();

        return $this;
    }

    /**
     * Remove an entry from the database.
     *
     * @param  Entry  $entry
     * @return this
     */
    public function remove(Entry $entry)
    {
        $entry->delete();

        return $this;
    }

    /**
     * Filter an array so it is eligible for updation.
     *
     * @param  array  $data
     * @return array
     */
    protected function cleanForUpdate(array $data)
    {
        $cleaned = $this->clean($data);

        array_forget($cleaned, ['activity', 'activity_id']);

        return $cleaned;
    }
}
