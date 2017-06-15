<?php

namespace App\Modules\Electrons\Submissions;

use App\Modules\Models\Submission;
use App\Modules\Nucleons\Service;

class SubmissionService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Submission
     */
    protected $model = Submission::class;

    /**
     * Get multiple submissions with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        if (array_has($params, 'entry')) {
            $query->ofEntry($params['entry']);
        }

        return $query->get();
    }

    /**
     * Create a new submission and return it.
     *
     * @param  array  $data
     * @return Submission
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);    

        $cleaned['entry_id'] = $data['entry'];

        $submission = Submission::create($cleaned);

        return $submission;
    }

    /**
     * Update an submission with new data.
     *
     * @param  Submission  $submission
     * @param  array       $data
     * @return this
     */
    public function update(Submission $submission, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $submission->{$field} = $value;
        }

        $submission->save();

        return $this;
    }

    /**
     * Remove an submission from the database.
     *
     * @param  Submission  $submission
     * @return this
     */
    public function remove(Submission $submission)
    {
        $submission->delete();

        return $this;
    }
}
