<?php

namespace App\Modules\Electrons\Questions;

use App\Modules\Models\Choice;
use App\Modules\Nucleons\Service;

class ChoiceService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Choice
     */
    protected $model = Choice::class;

    /**
     * Get multiple choices with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        if (array_has($params, 'question')) {
            $query->ofQuestion($params['question']);
        }

        return $query->get();
    }

    /**
     * Create a new choice and return it.
     *
     * @param  array  $data
     * @return Choice
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $cleaned['question_id'] = $data['question'];

        $choice = Choice::create($cleaned);

        return $choice;
    }

    /**
     * Update a choice with new data.
     *
     * @param  Choice  $choice
     * @param  array     $data
     * @return this
     */
    public function update(Choice $choice, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $choice->{$field} = $value;
        }

        $choice->save();

        return $this;
    }

    /**
     * Remove a choice from the database.
     *
     * @param  Choice  $choice
     * @return this
     */
    public function remove(Choice $choice)
    {
        $choice->delete();

        return $this;
    }
}
