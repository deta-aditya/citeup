<?php

namespace App\Modules\Api\V1\Requests\Users;

use App\User;
use App\Modules\Electrons\Keys\KeyService;
use App\Modules\Electrons\Activities\ActivityService;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class UserIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var User
     */
    protected $model = User::class;

    /**
     * A key service instance.
     *
     * @var KeyService
     */
    protected $keys;

    /**
     * A activity service instance.
     *
     * @var ActivityService
     */
    protected $activities;

    /**
     * Create a new request instance
     * 
     * @param  KeyService       $keys
     * @param  ActivityService  $activities
     * @return void
     */
    public function __construct(KeyService $keys, ActivityService $activities)
    {
        $this->keys = $keys;
        $this->activities = $activities;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('get', User::class);
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'role' => 'exists:roles,id',
            'name' => 'string',
            'section' => 'string',
            'activity' => 'exists:activities,id',
            'activities' => 'string',
            'stage' => 'int|between:0,5',
            'keys' => 'string',
            'alert' => 'exists:alerts,id',
        ];
    }

    /**
     * Run additional configuration for validation aside from the query string
     * validation.
     *
     * @param  Validator  $validator
     * @return void
     */
    protected function hook(Validator $validator)
    {
        $errors = $validator->errors();

        $this->evaluateKeys($errors)
             ->evaluateActivities($errors);
    }

    /**
     * Evaluate the keys parameter.
     *
     * @param  MessageBag  $errors
     * @return this
     */
    protected function evaluateKeys(MessageBag $errors) 
    {
        if (! $this->has('keys')) {
            return $this;
        }

        $keys = explode(config('queries.users.delimiters.keys'), $this->input('keys'));

        if ($this->keys->areInvalidId($keys)) {
            $errors->add('keys', trans('queries.ids'));
        }

        return $this;
    }

    /**
     * Evaluate the activities parameter.
     *
     * @param  MessageBag  $errors
     * @return this
     */
    protected function evaluateActivities(MessageBag $errors) 
    {
        if (! $this->has('activities')) {
            return $this;
        }

        $activities = explode($this->getDelimiter('activities'), $this->input('activities'));

        if ($this->activities->areInvalidId($activities)) {
            $errors->add('activities', trans('queries.ids'));
        }

        return $this;
    }
}
