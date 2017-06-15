<?php

namespace App\Modules\Electrons\Testimonials;

use App\Modules\Models\Testimonial;
use App\Modules\Nucleons\Service;

class TestimonialService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Testimonial
     */
    protected $model = Testimonial::class;

    /**
     * Get multiple testimonials with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        if (array_has($params, 'entry')) {
            $query->ofEntry($params['entry']);
        }

        if (array_has($params, 'rating')) {
            $query->ofRating($params['rating']);
        }

        return $query->get();
    }

    /**
     * Create a new testimonial and return it.
     *
     * @param  array  $data
     * @return Testimonial
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $cleaned['entry_id'] = $data['entry'];

        $testimonial = Testimonial::create($cleaned);

        return $testimonial;
    }

    /**
     * Update a testimonial with new data.
     *
     * @param  Testimonial  $testimonial
     * @param  array     $data
     * @return this
     */
    public function update(Testimonial $testimonial, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $testimonial->{$field} = $value;
        }

        $testimonial->save();

        return $this;
    }

    /**
     * Remove a testimonial from the database.
     *
     * @param  Testimonial  $testimonial
     * @return this
     */
    public function remove(Testimonial $testimonial)
    {
        $testimonial->delete();

        return $this;
    }
}
