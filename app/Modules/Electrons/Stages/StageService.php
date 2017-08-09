<?php

namespace App\Modules\Electrons\Stages;

use App\User;
use App\Modules\Models\Stage;
use App\Modules\Nucleons\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class StageService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Stage
     */
    protected $model = Stage::class;

    /**
     * The application's stages.
     * Caution: Do not modify!
     *
     * @var array
     */
    protected $stages = [
        [
            'name' => 'Pra-Pendaftaran', 
            'started_at' => '2017-08-01 23:59:59',
            'finished_at' => '2017-08-21 12:00:00',
        ],
        [
            'name' => 'Pendaftaran', 
            'started_at' => '2017-08-21 12:00:01',
            'finished_at' => '2017-10-14 23:59:59',
        ],
        [
            'name' => 'Pra-Seleksi', 
            'started_at' => '2017-10-15 00:00:00',
            'finished_at' => '2017-10-21 12:00:00',
        ],
        [
            'name' => 'Seleksi', 
            'started_at' => '2017-10-21 12:00:01',
            'finished_at' => '2017-10-21 23:59:59',
        ],
        [
            'name' => 'Final', 
            'started_at' => '2017-10-22 00:00:00',
            'finished_at' => '2017-11-05 23:00:00',
        ],
        [
            'name' => 'Paska-Acara', 
            'started_at' => '2017-11-05 23:00:01',
            'finished_at' => '2018-08-21 12:00:00',
        ],
    ];

    /**
     * Create all required stages.
     * Caution: This method should only be invoked once on a seeder!
     *
     * @return this
     */
    public function required()
    {
        $now = Carbon::now()->toDateTimeString();

        $insertables = [];

        foreach ($this->stages as $stage) {
            $insertables[] = $stage;
        }

        Stage::insert($insertables);

        return $this;
    }

    /**
     * Get multiple stages with conditions.
     *
     * @param  array  $params
     * @return Collection
     */
    public function multiple(array $params = [])
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        return $query->get();
    }

    /**
     * Update a stage with new data.
     *
     * @param  int|Stage  $stage
     * @param  array      $data
     * @return this
     */
    public function update($stage, array $data)
    {
        if (! $stage instanceof Stage) {
            $stage = Stage::find($stage);
        }

        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $stage->{$field} = $value;
        }

        $stage->save();

        return $this;
    }

    /**
     * Retrieve the current app's stage.
     *
     * @return Stage
     */
    public static function current() 
    {
        return Stage::current()->get()->first();
    }
}
