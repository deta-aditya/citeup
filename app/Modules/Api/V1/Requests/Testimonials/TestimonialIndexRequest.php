<?php

namespace App\Modules\Api\V1\Requests\Testimonials;

use App\Modules\Models\Testimonial;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class TestimonialIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Testimonial
     */
    protected $model = Testimonial::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('get', Testimonial::class);
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'entry' => 'int|exists:entries,id',
            'rating' => 'int|between:1,5',
        ];
    }
}
