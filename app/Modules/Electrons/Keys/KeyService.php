<?php

namespace App\Modules\Electrons\Keys;

use App\User;
use App\Modules\Models\Key;
use App\Modules\Nucleons\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KeyService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Key
     */
    protected $model = Key::class;

    /**
     * Get multiple keys with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        if (array_has($params, 'users')) {
            $query->ownedByUsers(explode(config(
                'queries.users.delimiters.keys'
            ), $params['users']));
        } 

        return $query->get();
    }

    /**
     * Create a new key and return it.
     *
     * @param  array  $data
     * @return Key
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $cleaned['slug'] = $this->slugify($cleaned['name']);        

        $key = Key::create($cleaned);

        return $key;
    }

    /**
     * Update a key with new data.
     *
     * @param  Key   $key
     * @param  array  $data
     * @return this
     */
    public function update(Key $key, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $key->{$field} = $value;
        }

        if (array_has($cleaned, 'name')) {
            $key->slug = $this->slugify($cleaned['name']);
        }

        $key->save();

        return $this;
    }

    /**
     * Remove a key from the database.
     *
     * @param  Key  $key
     * @return this
     */
    public function remove(Key $key)
    {
        $key->delete();

        return $this;
    }

    /**
     * Grant keys to a user.
     *
     * @param  User   $user
     * @param  array  $keys
     * @return this
     */
    public function grant(User $user, array $keys)
    {
        if (! empty($keys)) {

            $user->load('keys');

            $keys = collect($keys)->reject(function ($key) use ($user) {
                return $user->keys->contains($key);
            });

            $user->keys()->attach($keys);
        }

        return $this;
    }

    /**
     * Grant keys to a multiple users.
     *
     * @param  array  $users
     * @param  array  $keys
     * @return this
     */
    public function grantMultiple(array $users, array $keys)
    {
        $users = User::find($users);

        foreach ($users as $user) {
            $this->grant($user, $keys);
        }

        return $this;
    }

    /**
     * Ungrant keys from a user.
     *
     * @param  User   $user
     * @param  array  $keys
     * @return this
     */
    public function ungrant(User $user, array $keys)
    {
        if (! empty($keys)) {

            $user->load('keys');

            $keys = collect($keys)->reject(function ($key) use ($user) {
                return ! $user->keys->contains($key);
            });

            $user->keys()->detach($keys);
        }

        return $this;
    }

    /**
     * Ungrant keys to a multiple users.
     *
     * @param  array  $users
     * @param  array  $keys
     * @return this
     */
    public function ungrantMultiple(array $users, array $keys)
    {
        $users = User::find($users);

        foreach ($users as $user) {
            $this->ungrant($user, $keys);
        }

        return $this;
    }

    /**
     * Determine whether any of the given values is an invalid ID.
     * 
     * @param  array  $ids
     * @return bool 
     */
    public function areInvalidId(array $ids)
    {
        try {
            $this->getModel()->query()->findOrFail($ids);
        } catch (ModelNotFoundException $e) {
            return true;
        }

        return false;
    }

    /**
     * Converts an array of slugs to array of IDs.
     *
     * @param  array  $slugs
     * @return array
     */
    public function slugsToId($slugs)
    {
        return $this->getModel()->query()->ofSlugs($slugs)->pluck('id')->toArray();
    }

    /**
     * Returns the slugged string.
     *
     * @param  string  $sluggable
     * @return string
     */
    protected function slugify($sluggable)
    {
        return str_slug($sluggable, '-');
    }
}
