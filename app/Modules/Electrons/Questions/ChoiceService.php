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
     * Create multiple choices and return them.
     *
     * @param  int    $questionId
     * @param  array  $choices
     * @return array
     */
    public function createMultiple($questionId, array $choices)
    {
        $final = [];

        foreach ($choices as $choice) {

            if (! isset($choice['content'])) {
                continue;
            }

            $choice['question'] = $questionId;

            array_push($final, $this->create($choice));
        }

        return $final;
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
     * Update multiple choices.
     *
     * @param  array  $data
     * @return this
     */
    public function updateMultiple(array $data)
    {
        foreach ($data as $choice) {
            $this->update(Choice::find($choice['id']), array_except($choice, ['id']));
        }
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
