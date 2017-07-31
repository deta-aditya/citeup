<?php

namespace App\Modules\Electrons\Faqs;

use App\Modules\Models\Faq;
use App\Modules\Nucleons\Service;

class FaqService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Faq
     */
    protected $model = Faq::class;

    /**
     * Get multiple faqs with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        return $query->get();
    }

    /**
     * Create a new faq and return it.
     *
     * @param  array  $data
     * @return Faq
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $faq = Faq::create($cleaned);

        return $faq;
    }

    /**
     * Update a faq with new data.
     *
     * @param  Faq  $faq
     * @param  array     $data
     * @return this
     */
    public function update(Faq $faq, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $faq->{$field} = $value;
        }

        $faq->save();

        return $this;
    }

    /**
     * Remove a faq from the database.
     *
     * @param  Faq  $faq
     * @return this
     */
    public function remove(Faq $faq)
    {
        $faq->delete();

        return $this;
    }
}
