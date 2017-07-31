<?php

namespace App\Modules\Electrons\Galleries;

use App\Modules\Models\Gallery;
use App\Modules\Nucleons\Service;

class GalleryService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Gallery
     */
    protected $model = Gallery::class;

    /**
     * Get multiple galleries with conditions.
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
     * Create a new gallery and return it.
     *
     * @param  array  $data
     * @return Gallery
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $gallery = Gallery::create($cleaned);

        return $gallery;
    }

    /**
     * Update a gallery with new data.
     *
     * @param  Gallery   $gallery
     * @param  array     $data
     * @return this
     */
    public function update(Gallery $gallery, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $gallery->{$field} = $value;
        }

        $gallery->save();

        return $this;
    }

    /**
     * Remove a gallery from the database.
     *
     * @param  Gallery  $gallery
     * @return this
     */
    public function remove(Gallery $gallery)
    {
        $gallery->delete();

        return $this;
    }
}
