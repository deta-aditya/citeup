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
    */

    /* 
        Config.php architecture:

        landing : {
            countdown : {
                active : Boolean
                off : String (DateTime)
                text : String
            }
            activities : {
                order : [{
                    id : Number
                    name : String
                }]
            }
            show : {
                name : Boolean
            }
        }

        prizes : [{
            id : Number
            name: String
            first : Number
            second : Number
            third : Number
        }]
        
        address : {
            location : {
                lat : Number
                lng : Number
            }
        }

        stage: { // Current stage
            name : String
            end : String (DateTime)
        }

        stages : [{
            name : String
            end : String (DateTime)
        }]

        contact: {
            email : String (Email) 
            facebook : String
            twitter : String
            instagram : String
            line : String
            phones : {
                name : Number
            }
        }

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
