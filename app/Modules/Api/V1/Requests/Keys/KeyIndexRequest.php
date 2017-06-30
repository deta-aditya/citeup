<?php

namespace App\Modules\Api\V1\Requests\Keys;

use App\Modules\Models\Key;
use App\Modules\Electrons\Keys\KeyService;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class KeyIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Key
     */
    protected $model = Key::class;

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
        return $this->user()->can('get', Key::class);
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'users' => 'string',
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

        $this->evaluateUsers($errors);
    }

    /**
     * Evaluate the users parameter.
     *
     * @param  MessageBag  $errors
     * @return this
     */
    protected function evaluateUsers(MessageBag $errors) 
    {
        if (! $this->has('users')) {
            return $this;
        }

        $users = explode(config('queries.users.delimiters.keys'), $this->input('users'));

        if ($this->users->areInvalidId($users)) {
            $errors->add('users', trans('queries.ids'));
        }

        return $this;
    }
}
