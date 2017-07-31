<?php

namespace App\Modules\Electrons\Questions;

use App\Modules\Models\Question;
use App\Modules\Nucleons\Service;

class QuestionService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Question
     */
    protected $model = Question::class;

    /**
     * Get multiple questions with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        return $query->get();
    }

    /**
     * Create a new question and return it.
     *
     * @param  array  $data
     * @return Question
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $question = Question::create($cleaned);

        return $question;
    }

    /**
     * Update a question with new data.
     *
     * @param  Question  $question
     * @param  array     $data
     * @return this
     */
    public function update(Question $question, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $question->{$field} = $value;
        }

        $question->save();

        return $this;
    }

    /**
     * Remove a question from the database.
     *
     * @param  Question  $question
     * @return this
     */
    public function remove(Question $question)
    {
        $question->delete();

        return $this;
    }
}
