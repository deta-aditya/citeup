<?php

namespace App\Modules\Electrons\Questions;

use App\Modules\Models\Answer;
use App\Modules\Models\Choice;
use App\Modules\Nucleons\Service;

class AnswerService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Answer
     */
    protected $model = Answer::class;

    /**
     * Get multiple answers with conditions.
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

        if (array_has($params, 'choice')) {
            $query->ofChoice($params['choice']);
        }

        if (array_has($params, 'attempt')) {
            $query->ofAttempt($params['attempt']);
        }

        return $query->get();
    }

    /**
     * Create a new answer and return it.
     *
     * @param  int  $attemptId
     * @param  int  $choiceId
     * @return Answer
     */
    public function create($attemptId, $choiceId)
    {
        $this->free($attemptId, $choiceId);

        $answer = Answer::create([
            'attempt_id' => $attemptId,
            'choice_id' => $choiceId,
        ]);

        return $answer;
    }

    /**
     * Create multiple answers and return them.
     *
     * @param  int    $attemptId
     * @param  array  $answers
     * @return array
     */
    public function createMultiple($attemptId, array $answers)
    {
        $final = [];

        foreach ($answers as $choice) {
            array_push($final, $this->create($attemptId, $choice));
        }

        return $final;
    }

    /**
     * Free the question of the current choice.
     *
     * @param  int  $attemptId
     * @param  int  $choiceId
     * @return this
     */
    public function free($attemptId, $choiceId)
    {
        Answer::ofQuestion(Choice::find($choiceId)->question_id)
            ->ofAttempt($attemptId)
            ->delete();

        return $this;
    }

    /**
     * Remove a answer from the database.
     *
     * @param  Answer  $answer
     * @return this
     */
    public function remove(Answer $answer)
    {
        $answer->delete();

        return $this;
    }
}
