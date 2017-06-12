<?php

namespace App\Modules\Electrons\Shared\Requests;

use Illuminate\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Electrons\Shared\Services\QueryConfigurations;
use Carbon\Carbon;

class ApiIndexRequest extends FormRequest 
{
    use QueryConfigurations;

    /**
     * The main model for the request.
     *
     * @var null
     */
    protected $model = null;

    /**
     * The table name of the model above.
     * Leave this empty.
     *
     * @var string
     */
    protected $tableName = '';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'select' => 'string',
            'sort' => 'string',
            'criteria' => 'string',
            'skip' => 'integer|min:0',
            'take' => 'integer|min:0',
            'random' => 'string|in:true,false',
            'with' => 'string',
            'clean' => 'string|in:true,false',
        ];

        return array_merge($rules, $this->additional());
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            
            $errors = $validator->errors();

            $this->evaluateSort($errors)
                ->evaluateCriteria($errors);

            $this->hook($validator);
            
        });
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            //
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
        //
    }

    /**
     * Evaluate the sort parameter.
     *
     * @param  MessageBag  $errors
     * @return this
     */
    protected function evaluateSort(MessageBag $errors)
    {
        if (! $this->has('sort')) {
            return $this;
        }

        $sorts = explode($this->getDelimiter('sort.per_field'), $this->input('sort'));

        foreach ($sorts as $sort) {
            list($field, $direction) = explode($this->getDelimiter('sort.per_value'), $sort);

            if (! in_array($direction, ['asc', 'desc'])) {
                $errors->add('sort', trans('queries.sort'));
            }
        }

        return $this;
    }

    /**
     * Evaluate the criteria parameter.
     *
     * @param  MessageBag  $errors
     * @return this
     */
    protected function evaluateCriteria(MessageBag $errors)
    {
        if (! $this->has('criteria')) {
            return $this;
        }

        $criterias = explode($this->getDelimiter('criteria.per_field'), $this->input('criteria'));

        foreach ($criterias as $criteria) {
            
            list($field, $command, $value) = explode($this->getDelimiter('criteria.per_value'), $criteria);

            switch ($command) {
                
                case 'is':
                    
                    if (! in_array($value, ['null', 'notnull'])) {
                        $errors->add('criteria', trans('queries.criteria.is'));
                    }

                    break;
                
                case 'date':

                    try {
                        if (Carbon::createFromFormat('Y-m-d', $value) === false) {
                            $errors->add('criteria', trans('queries.criteria.date'));
                        }
                    } catch (\InvalidArgumentException $e) {
                        $errors->add('criteria', trans('queries.criteria.date'));
                    }
                    
                    break;
                
                case 'month':

                    if ((int) $value < 1 || (int) $value > 12) {
                        $errors->add('criteria', trans('queries.criteria.month'));
                    }
                    
                    break;
                
                case 'day':
                    
                    if ((int) $value < 1 || (int) $value > 31) {
                        $errors->add('criteria', trans('queries.criteria.day'));
                    }

                    break;
                
                case 'column':

                    list($command, $column) = explode($this->getDelimiter('criteria.per_subvalue'), $value);

                    if (! in_array($command, ['<', '<=', '=', '>=', '>', '<>'])) {
                        $errors->add('criteria', trans('queries.criteria.column'));
                    }
                    
                    break;
            }
        }

        return $this;
    }
}
