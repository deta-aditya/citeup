<?php

namespace App\Modules\Api\V1\Requests\Alerts;

use App\Modules\Models\Alert;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class AlertIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Alert
     */
    protected $model = Alert::class;

    /**
     * A user service instance.
     *
     * @var UserService
     */
    protected $users;

    /**
     * Create a new request instance
     * 
     * @param  UserService  $users
     * @return void
     */
    public function __construct(UserService $users)
    {
        $this->users = $users;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        if (strpos($this->url(), 'users/') !== false) {
            $other = $this->route('user')->id === $user->id;
        } else {
            $other = ! $this->has('users'); 
        }

        return $user->isAdmin() || $user->hasKey('get-alerts') || (
            $other && 
            $this->input('seenby', $user->id) == $user->id &&
            $this->input('unseenby', $user->id) == $user->id
        );
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'announced' => 'string|in:true,false',
            'unannounced' => 'string|in:true,false',
            'users' => 'string',
            'seenby' => 'int|exists:users,id',
            'unseenby' => 'int|exists:users,id',
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

        $this->evaluateUsers($errors, 'users');
    }

    /**
     * Evaluate the users in the given parameter field.
     *
     * @param  MessageBag  $errors
     * @param  string      $field
     * @return this
     */
    protected function evaluateUsers(MessageBag $errors, $field) 
    {
        if ($this->has($field)) {
            $users = explode($this->getDelimiter('users'), $this->input($field));

            if ($this->users->areInvalidId($users)) {
                $errors->add($field, trans('queries.ids'));
            }
        }

        return $this;
    }
}
