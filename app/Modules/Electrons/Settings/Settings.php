<?php

namespace App\Modules\Electrons\Settings;

use Illuminate\Support\Facades\DB;
use App\Modules\Electrons\Settings\Category;
use App\Modules\Electrons\Settings\Collection;

class Settings
{
    /**
     * The initial values of settings keys.
     *
     * @var null|Collection 
     */
    protected $initials = null;

    /**
     * The mutable settings keys.
     *
     * @var null|Collection
     */
    protected $keys = null;

    /**
     * The settings table's name.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The application's settings.
     * Caution: Do not modify!
     *
     * @var array
     */
    protected $settings = [
        ['key' => 'show.welcometron', 'value' => true, 'type' => 'bool'],
        ['key' => 'show.activities', 'value' => true, 'type' => 'bool'],
        ['key' => 'show.testimonials', 'value' => false, 'type' => 'bool'],
        ['key' => 'show.prizes', 'value' => true, 'type' => 'bool'],
        ['key' => 'show.map', 'value' => true, 'type' => 'bool'],
        ['key' => 'show.faqs', 'value' => true, 'type' => 'bool'],
        ['key' => 'show.news', 'value' => true, 'type' => 'bool'],
        ['key' => 'show.galleries', 'value' => false, 'type' => 'bool'],
        ['key' => 'show.contact', 'value' => true, 'type' => 'bool'],
        ['key' => 'show.sponsors', 'value' => true, 'type' => 'bool'],
        ['key' => 'countdown.active', 'value' => true, 'type' => 'bool'],
        ['key' => 'countdown.off', 'value' => '2017-08-21 12:00:00', 'type' => 'string'],
        ['key' => 'countdown.text', 'value' => 'Pendaftaran akan dibuka dalam:', 'type' => 'string'],
        ['key' => 'location.lat', 'value' => -6.2284204553772, 'type' => 'float'],
        ['key' => 'location.lng', 'value' => 106.78988412023, 'type' => 'float'],
        ['key' => 'contact.email', 'value' => '', 'type' => 'string'],
        ['key' => 'contact.facebook', 'value' => '', 'type' => 'string'],
        ['key' => 'contact.twitter', 'value' => '', 'type' => 'string'],
        ['key' => 'contact.instagram', 'value' => '', 'type' => 'string'],
        ['key' => 'contact.line', 'value' => '', 'type' => 'string'],
    ];

    /**
     * Create a new settings instance.
     *
     * @return void
     */
    public function __construct()
    {
        $source = $this->getFromDb();

        if ($source->isNotEmpty()) {
            $this->setInitials($source)->populateKeys(clone $source);
        }
    }

    /**
     * Get a key under the given name.
     *
     * @param  string  $name
     * @param  mixed   $default
     * @return mixed
     */
    public function getKey($name, $default = null)
    {
        return $this->keys->get($name, $default);
    }

    /**
     * Set a key of the given name with a given value.
     *
     * @param  string  $name
     * @param  mixed   $value
     * @return this
     */
    public function setKey($name, $value)
    {
        $this->keys->put($name, $value);

        return $this;
    }

    /**
     * Return all of the available keys.
     *
     * @return array
     */
    public function all()
    {
        return $this->keys->toArray();
    }

    /**
     * Set and save multiple keys to the settings. 
     *
     * @param  array  $keys
     * @return this
     */
    public function edit($keys)
    {
        foreach ($keys as $key => $value) {
            if (! is_array($value)) {
                $this->{$key} = $value;
                continue;
            }

            foreach ($value as $subkey => $subvalue) {
                $this->{$key}->{$subkey} = $subvalue;
            }
        }

        return $this->persist();
    }

    /**
     * Set and save multiple keys to the settings with JSON input.
     *
     * @param  string  $json
     * @return this
     */
    public function editInJson($json)
    {
        return $this->edit(json_decode($json, true));
    }

    /**
     * Save the current changes.
     *
     * @return this
     */
    public function persist()
    {
        $saveable = $this->uncategorize($this->getDiffs());

        return $this->setToDb($saveable)
                    ->setInitials($saveable)
                    ->populateKeys(clone $saveable);
    }

    /**
     * Create all required settings.
     * Caution: This method should only be invoked once on a seeder!
     *
     * @return this
     */
    public function required()
    {
        DB::table($this->table)->insert($this->settings);

        return $this;
    }

    /**
     * Categorize the given collection.
     *
     * @param  Collection  $data
     * @return Collection
     */
    public function categorize(Collection $data)
    {
        $categorized = [];

        foreach ($data as $item) {
            
            if (! str_contains($item->key, '.')) {
                $categorized[$item->key] = $item->value;
                continue;
            }

            list($category, $subcategory) = explode('.', $item->key);

            if (! array_has($categorized, $category)) {
                $categorized[$category] = new Category;
            }

            $categorized[$category]->{$subcategory} = $this->cast($item->value, $item->type);

        }

        return $this->collect($categorized);
    }

    /**
     * Cast the given value to the given type.
     * Possible values of 'type' are based on PHP's settype().
     *
     * @param  mixed   $value
     * @param  string  $type
     * @return mixed
     */
    public function cast($value, $type)
    {
        settype($value, $type);

        return $value;
    }

    /**
     * Uncategorize the given collection.
     *
     * @param  Collection  $data
     * @return Collection
     */
    public function uncategorize(Collection $data)
    {
        return $this->collect(array_dot(json_decode($data->toJson(), true)));
    }

    /**
     * Get a collection of data changes since the last save.
     *
     * @return Collection
     */
    public function getDiffs()
    {
        return $this->collect($this->keys->diff($this->initials));
    }

    /**
     * Set the initial keys with the given source
     *
     * @param  Collection  $source
     * @return this
     */
    public function setInitials(Collection $source)
    {
        $this->initials = $source;

        return $this;
    }

    /**
     * Populate the settings keys from the given collection source.
     *
     * @param  Collection  $source
     * @return this
     */
    public function populateKeys(Collection $source)
    {
        $this->keys = $source;

        return $this;
    }

    /**
     * Wrap the given array or base collection into settings collection.
     *
     * @param  array|Collection  $list
     * @return Collection
     */
    public function collect($list = [])
    {
        return Collection::make($list);
    }

    /**
     * Get keys source from database.
     *
     * @return Collection
     */
    protected function getFromDb()
    {
        return $this->categorize($this->collect(DB::table($this->table)->get()));
    }

    /**
     * Save the given keys to the database.
     *
     * @param  Collection  $keys
     * @return this
     */
    protected function setToDb($keys)
    {
        foreach ($keys as $key => $value) {
            DB::table($this->table)->where('key', $key)->update(['value' => $value]);
        }

        return $this;
    }

    /**
     * Dynamically get a key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getKey($key);
    }

    /**
     * Dynamically set a key.
     *
     * @param  string  $key
     * @param  mixed   $val
     * @return void
     */
    public function __set($key, $val)
    {
        $this->setKey($key, $val);
    }
}
