<?php

namespace App\Modules\Electrons\Keys;

use App\User;
use App\Modules\Models\Key;
use App\Modules\Nucleons\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class KeyService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Key
     */
    protected $model = Key::class;

    /**
     * The application access keys.
     * Caution: Do not modify!
     *
     * @var array
     */
    protected $keys = [

        // "Users" Keys
        'Get Users', 'View Users', 'Post Users', 'Put Users', 'Delete Users', 
        'Post Users Alerts', 'Post Users Entries',

        // "Alerts" Keys
        'Get Alerts', 'View Alerts', 'Post Alerts', 
        'Put Alerts', 'Delete Alerts', 'Post Alerts Users', 

        // "Activities" Keys
        'Get Activities', 'View Activities', 'Post Activities', 
        'Put Activities', 'Delete Activities', 'Post Activities Schedules', 

        // "Schedules" Keys
        'Get Schedules', 'View Schedules', 'Post Schedules', 
        'Put Schedules', 'Delete Schedules', 

        // "Entries" Keys
        'Get Entries', 'Post Entries', 'Post Entries Submissions', 
        'Post Entries Documents', 'Post Entries Testimonials',
        'Post Entries Attempts', 

        // "Submissions" Keys
        'Get Submissions', 'View Submissions', 'Post Submissions', 
        'Put Submissions', 'Delete Submissions',

        // "Documents" Keys
        'Get Documents', 'View Documents', 'Post Documents', 
        'Put Documents', 'Delete Documents',

        // "Testimonials" Keys
        'Get Testimonials', 'View Testimonials', 'Post Testimonials', 
        'Put Testimonials', 'Delete Testimonials',

        // "Attempts" Keys
        'Get Attempts', 'View Attempts', 'Post Attempts', 
        'Put Attempts', 'Delete Attempts', 'Post Attempts Answers',

        // "Questions" Keys
        'Get Questions', 'View Questions', 'Post Questions', 
        'Put Questions', 'Delete Questions', 'Post Questions Choices',

        // "Choices" Keys
        'Get Choices', 'View Choices', 'Post Choices', 
        'Put Choices', 'Delete Choices',

        // "Answers" Keys
        'Get Answers', 'View Answers', 'Post Answers', 'Delete Answers',

        // "Galleries" Keys
        'Get Galleries', 'View Galleries', 'Post Galleries', 
        'Put Galleries', 'Delete Galleries',

        // "News" Keys
        'Get News', 'View News', 'Post News', 
        'Put News', 'Delete News',

        // "Sponsors" Keys
        'Get Sponsors', 'View Sponsors', 'Post Sponsors', 
        'Put Sponsors', 'Delete Sponsors',

        // "Faqs" Keys
        'Get Faqs', 'View Faqs', 'Post Faqs', 
        'Put Faqs', 'Delete Faqs',

        // "Edits" Keys
        'Get Edits',
        
    ];

    /**
     * Create all required keys.
     * Caution: This method should only be invoked once on a seeder!
     *
     * @return this
     */
    public function createAllRequired()
    {
        $now = Carbon::now()->toDateTimeString();

        $insertables = [];

        foreach ($this->keys as $key) {
            $insertables[] = [
                'name' => $key, 
                'slug' => $this->slugify($key),
                'created_at' => $now,
            ];
        }

        Key::insert($insertables);

        return $this;
    }

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
