<?php

namespace App\Modules\Electrons\Alerts;

use App\User;
use App\Modules\Models\Alert;
use App\Modules\Nucleons\Service;
use Carbon\Carbon;

class AlertService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Alert
     */
    protected $model = Alert::class;

    /**
     * Get multiple alerts with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        return $this->getMultipleCustomQuery($this->getModel()->query(), $params);
    }

    /**
     * Get multiple alerts with custom query and conditions.
     *
     * @param  Builder  $query
     * @param  array    $params
     * @return array
     */
    public function getMultipleCustomQuery($query, array $params)
    {
        $query = $this->parseQueryString($query, $params);

        if (array_has($params, 'sort')) {
            $this->additionalSort($query, $params['sort']);
        }

        if (array_has($params, 'announced') && $params['announced'] === 'true') {
            $query->announced();
        }

        if (array_has($params, 'unannounced') && $params['unannounced'] === 'true') {
            $query->unannounced();
        }

        if (array_has($params, 'users')) {
            
            $query->forUsers(explode($this->getDelimiter('users'), $params['users']));

        } else {

            if (! (auth('api')->user()->isAdmin() || auth('api')->user()->hasKey('get-alerts'))) {
                $query->forUsers(array_wrap(auth('api')->user()->id));
            } 

        }

        if (array_has($params, 'seenby')) {
            $query->seenBy($params['seenby']);
        }

        if (array_has($params, 'unseenby')) {
            $query->unseenBy($params['unseenby']);
        }

        return $query->get();
    }

    /**
     * Create a new alert and return it.
     *
     * @param  array  $data
     * @return Alert
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);    

        $alert = Alert::create($cleaned);

        return $alert;
    }

    /**
     * Update an alert with new data.
     *
     * @param  Alert  $alert
     * @param  array  $data
     * @return this
     */
    public function update(Alert $alert, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $alert->{$field} = $value;
        }

        $alert->save();

        return $this;
    }

    /**
     * Remove an alert from the database.
     *
     * @param  Alert  $alert
     * @return this
     */
    public function remove(Alert $alert)
    {
        $alert->delete();

        return $this;
    }

    /**
     * Perform an additional sort on the given query.
     *
     * @param  Builder  $query
     * @param  string   $sort
     * @return this
     */
    public function additionalSort($query, $sort)
    {
        $sorts = $this->parseSortParams($sort);

        if (array_has($sorts, 'pivot_seen_at')) {
            $query->sortBySeenAt($sorts['pivot_seen_at']);
        }

        if (array_has($sorts, 'pivot_announced_at')) {
            $query->sortByAnnouncedAt($sorts['pivot_announced_at']);
        }

        return $this;
    }

    /**
     * Announce the alerts to the given user.
     *
     * @param  User   $user
     * @param  array  $alerts
     * @return this
     */
    public function announce(User $user, array $alerts)
    {
        if (! empty($alerts)) {

            $user->load('alerts');

            $alerts = collect($alerts)->reject(function ($alert) use ($user) {
                return $user->alerts->contains($alert);
            });

            $user->alerts()->attach($alerts, ['announced_at' => Carbon::now()]);
        }

        return $this;
    }

    /**
     * Announce the alerts to multiple users.
     *
     * @param  array  $users
     * @param  array  $alerts
     * @return this
     */
    public function announceMultiple(array $users, array $alerts)
    {
        $users = User::find($users);

        foreach ($users as $user) {
            $this->announce($user, $alerts);
        }

        return $this;
    }

    /**
     * Unannounce the alerts to the given user.
     *
     * @param  User   $user
     * @param  array  $alerts
     * @return this
     */
    public function unannounce(User $user, array $alerts)
    {
        if (! empty($alerts)) {

            $user->load('alerts');

            $alerts = collect($alerts)->reject(function ($alert) use ($user) {
                return ! $user->alerts->contains($alert);
            });

            $user->alerts()->detach($alerts);
        }

        return $this;
    }

    /**
     * Unannounce the alerts to multiple users.
     *
     * @param  array  $users
     * @param  array  $alerts
     * @return this
     */
    public function unannounceMultiple(array $users, array $alerts)
    {
        $users = User::find($users);

        foreach ($users as $user) {
            $this->unannounce($user, $alerts);
        }

        return $this;
    }

    /**
     * See alerts by the given user.
     *
     * @param  User   $user
     * @param  array  $alerts
     * @return this
     */
    public function see(User $user, array $alerts)
    {
        if (! empty($alerts)) {

            $user->load('alerts');

            $alerts = collect($alerts)->reject(function ($alert) use ($user) {
                return ! $user->alerts->contains($alert);
            });

            foreach ($alerts->all() as $alert) {

                $user->alerts()->updateExistingPivot($alert, [
                    'seen_at' => Carbon::now(),
                ]);

            }
        }

        return $this;
    }

    /**
     * Unsee alerts by the given user.
     *
     * @param  User   $user
     * @param  array  $alerts
     * @return this
     */
    public function unsee(User $user, array $alerts)
    {
        if (! empty($alerts)) {

            $user->load('alerts');

            $alerts = collect($alerts)->reject(function ($alert) use ($user) {
                return ! $user->alerts->contains($alert);
            });

            foreach ($alerts->all() as $alert) {

                $user->alerts()->updateExistingPivot($alert, [
                    'seen_at' => null,
                ]);

            }
        }

        return $this;
    }
}
