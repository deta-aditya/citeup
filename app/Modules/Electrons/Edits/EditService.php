<?php

namespace App\Modules\Electrons\Edits;

use App\User;
use App\Modules\Models\Edit;
use App\Modules\Nucleons\Service;
use App\Modules\Contracts\Models\Editable;

class EditService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Edit
     */
    protected $model = Edit::class;

    /**
     * Get multiple edits with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        if (array_has($params, 'activity')) {
            $query->ofActivity($params['activity']);
        }

        if (array_has($params, 'schedule')) {
            $query->ofSchedule($params['schedule']);
        }

        if (array_has($params, 'news')) {
            $query->ofNews($params['news']);
        }

        if (array_has($params, 'gallery')) {
            $query->ofGallery($params['activity']);
        }

        return $query->get();
    }

    /**
     * Log a new edit.
     *
     * @param  Editable  $editable
     * @param  User      $performer
     * @return Edit
     */
    public function log(Editable $editable, User $performer)
    {
        $edit = $this->getModel();

        $edit->user_id = $performer->id;

        $editable->edits()->save($edit);

        return $edit;
    }
}
