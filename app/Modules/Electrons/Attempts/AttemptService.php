<?php

namespace App\Modules\Electrons\Attempts;

use App\Modules\Models\Attempt;
use App\Modules\Nucleons\Service;

class AttemptService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Attempt
     */
    protected $model = Attempt::class;

    /**
     * Get multiple attempts with conditions.
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

        if (array_has($params, 'finished') && $params['finished'] === 'true') {
            $query->finished();
        }

        if (array_has($params, 'unfinished') && $params['unfinished'] === 'true') {
            $query->unfinished();
        }

        return $query->get();
    }

    /**
     * Start a new attempt and return it.
     *
     * @param  int     $entryId
     * @param  string  $startedAt
     * @return Attempt
     */
    public function start($entryId, $startedAt)
    {
        return Attempt::create([
            'entry_id' => $entryId,
            'started_at' => $startedAt,
        ]);
    }

    /**
     * Finish an attempt.
     *
     * @param  Attempt  $attempt
     * @param  string   $finishedAt
     * @return this
     */
    public function finish(Attempt $attempt, $finishedAt)
    {
        if (is_null($finishedAt)) {
            return $this;
        }

        $attempt->finished_at = $finishedAt;

        $attempt->save();

        return $this;
    }

    /**
     * Remove an attempt from the database.
     *
     * @param  Attempt  $attempt
     * @return this
     */
    public function remove(Attempt $attempt)
    {
        $attempt->delete();

        return $this;
    }
}
