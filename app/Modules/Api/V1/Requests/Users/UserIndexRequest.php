<?php

namespace App\Modules\Api\V1\Requests\Users;

use App\User;
use App\Modules\Electrons\Keys\KeyService;
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
     * Create a new request instance
     * 
     * @param  KeyService  $keys
     * @return void
     */
    public function __construct(KeyService $keys)
    {
        $this->keys = $keys;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'stage' => 'int|between:0,4',
            'keys' => 'string',
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

        $this->evaluateKeys($errors);
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
            $errors->add('keys', trans('queries.keys'));
        }

        return $this;
    }
}
