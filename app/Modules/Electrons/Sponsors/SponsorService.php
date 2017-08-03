<?php

namespace App\Modules\Electrons\Sponsors;

use App\Modules\Models\Sponsor;
use App\Modules\Nucleons\Service;

class SponsorService extends Service
{
    /**
     * The sponsor type.
     */
    const TYPE_SPONSOR = 1;

    /**
     * The media partner type.
     */
    const TYPE_MEDIA_PARTNER = 2;

    /**
     * The URL to the default picture.
     *
     * @var string
     */
    protected $defaultPicture = 'images/default.jpg';

    /**
     * The main model for the service.
     *
     * @var Sponsor
     */
    protected $model = Sponsor::class;

    /**
     * Get multiple sponsors with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->parseQueryString($this->getModel()->query(), $params);

        if (array_has($params, 'type')) {
            $query->ofType((int) $params['type']);
        }

        return $query->get();
    }

    /**
     * Create a new sponsor and return it.
     *
     * @param  array  $data
     * @return Sponsor
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        if (! array_has($cleaned, 'picture')) {
            $cleaned['picture'] = $this->defaultPicture;
        }

        $sponsor = Sponsor::create($cleaned);

        return $sponsor;
    }

    /**
     * Update a sponsor with new data.
     *
     * @param  Sponsor  $sponsor
     * @param  array     $data
     * @return this
     */
    public function update(Sponsor $sponsor, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $sponsor->{$field} = $value;
        }

        $sponsor->save();

        return $this;
    }

    /**
     * Remove a sponsor from the database.
     *
     * @param  Sponsor  $sponsor
     * @return this
     */
    public function remove(Sponsor $sponsor)
    {
        $sponsor->delete();

        return $this;
    }
}
