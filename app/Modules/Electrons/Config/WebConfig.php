<?php

namespace App\Modules\Electrons\Config;

use Illuminate\Support\Facades\File;
use App\Modules\Electrons\Stages\StageService;
use App\Modules\Electrons\Config\Editor;

class WebConfig
{
    /*
    |--------------------------------------------------------------------------
    | WebConfig Class
    |--------------------------------------------------------------------------
    |
    | This class is an interface for interacting with config/web.php file as well
    | as the StagesService class.
    |
    */

    /**
     * The name of the config.
     *
     * @var string
     */
    protected $name = 'web';

    /**
     * The editor instance.
     *
     * @var Editor
     */
    protected $editor;

    /**
     * The stage service instance.
     *
     * @var StageService
     */
    protected $stages;

    /**
     * The cached config data.
     *
     * @var Collection
     */
    protected $cache = null;

    /**
     * Create a new config instance.
     *
     * @param  StageService  $stages
     * @return void
     */
    public function __construct(StageService $stages, Editor $editor)
    {
        $this->stages = $stages;
        $this->editor = $editor;

        $this->cacheData();
    }

    /**
     * Get config data under specified path.
     *
     * @param  string      $path
     * @param  mixed|null  $default
     * @return mixed
     */
    public function get($path, $default = null)
    {
        return $this->cache->get($path, $default);
    }

    /**
     * Get all of the config data.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->cache->toArray();
    }

    /**
     * Set an array of config data.
     *
     * @param  array  $data
     * @return this
     */
    public function set($data)
    {
        if (! is_array($data)) {
            $data = $this->decode($data);
        }

        if (array_has($data, 'stages')) {
            $this->setStages(array_pull($data, 'stages'));
        }

        return $this->setConfigs($this->clean($data));
    }

    /**
     * Clean the incoming config data.
     *
     * @param  array  $data
     * @return array
     */
    public function clean($data)
    {
        if (array_has($data, 'stage')) {
            array_forget($data, 'stage');
        }

        return $data;
    }

    /**
     * Check whether the file is cached or not.
     *
     * @return bool
     */
    public function cached()
    {
        return ! is_null($this->cache);
    }

    /**
     * Cache the config data.
     *
     * @return this
     */
    public function cacheData() 
    {
        return $this->cacheConfigs()->cacheStages();
    }

    /**
     * Decode a JSON string input into an array.
     *
     * @param  string  $json
     * @return array
     */
    public function decode($json)
    {
        return json_decode($json, true);
    }

    /**
     * Cache the config data from the config file.
     *
     * @return this
     */
    protected function cacheConfigs()
    {
        if (! $this->cached()) {
            $this->cache = collect([]);
        }
        
        $this->cache = $this->cache->merge(config($this->name));

        return $this;
    }

    /**
     * Set the config data to the config file.
     * 
     * @param  array  $data
     * @return this
     */
    protected function setConfigs($data)
    {

        dd((config('web.landing')));
        // $this->editor->load();

        // foreach (array_dot($data) as $key => $value) {
        //     $this->editor->set($key, $value);
        // }

        // $this->editor->save();

        return $this;
    }

    /**
     * Cache the stages data.
     *
     * @return this
     */
    protected function cacheStages()
    {
        if (! $this->cached()) {
            $this->cache = collect([]);
        }

        $this->cache->put('stages', $this->stages->multiple());

        return $this;
    }

    /**
     * Set new stages data.
     *
     * @param  array  $stages
     * @return this
     */
    protected function setStages($data)
    {
        foreach ($data as $stage) {
            $this->stages->update($stage['id'], $stage);
        }

        return $this;
    }
}
