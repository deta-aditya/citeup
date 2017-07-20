<?php

namespace App\Modules\Electrons\Config;

use Illuminate\Support\Facades\Storage;

class Config
{
    /*
    |--------------------------------------------------------------------------
    | Config Class
    |--------------------------------------------------------------------------
    |
    | This class is an interface for interacting with config.json file, which
    | serves as the main configuration for the application. No, I'm not storing
    | them in database anymore. Anyway here is the available keys list:
    |
    | > countdown : Object
    |   This key stores information for the countdown element in the landing
    |   page.
    |
    |   {
    |     > active : Boolean
    |       Determines whether the countdown is active or not.
    |
    |     > off : String
    |       A datetime string with 'Y-m-d H:i:s' format which is the deadline of 
    |       the countdown.
    |   } 
    */

    /**
     * The config file in the local storage.
     *
     * @var string
     */
    protected $file = 'config.json';

    /**
     * The cache of the config data
     *
     * @var Collection
     */
    protected $cache = null;

    /**
     * Create a new config instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $this->cache = $this->cache->merge($data);

        $this->putToFile($this->cache->toJson());

        return $this;
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
        $this->cache = collect($this->decode($this->getFromFile()));

        return $this;
    }

    /**
     * Get the config file contents in string.
     *
     * @return string
     */
    public function getFromFile()
    {
        return Storage::disk('local')->get($this->file);
    }

    /**
     * Put the given data to the config file
     * 
     * @param  array  $data
     * @return this
     */
    public function putToFile($data)
    {
        Storage::disk('local')->put($this->file, $data);

        return $this;
    }

    /**
     * Decode a JSON string to PHP array.
     * 
     * @param  string  $jsonString
     * @return array
     */
    public function decode($jsonString) 
    {
        return json_decode($jsonString, true);
    }
}
