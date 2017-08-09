<?php

namespace App\Modules\Electrons\Config;

use Illuminate\Support\Facades\File;

class Editor
{
    /**
     * The name of the config file.
     *
     * @var string
     */
    protected $name = 'web';

    /**
     * The contents of the file.
     *
     * @var string
     */
    protected $contents;

    /**
     * Load the config file.
     *
     * @return this
     */
    public function load()
    {
        $this->contents = File::get($this->file());
    }

    /**
     * Set a new config data.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return this  
     */
    public function set($key, $value)
    {

    }

    /**
     * Stringify an array.
     *
     * @param  array  $array
     * @return string
     */
    public function stringify($array)
    {
        $returnable = '[';

        foreach ($array as $key => $value) {
            $returnable .= $key . '=>' . $value ','   
        }
    }

    /**
     * Returns the config path file.
     *
     * @return string
     */
    protected function file()
    {
        return config_path('web.php');
    }
}
