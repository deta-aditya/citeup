<?php

namespace App\Modules\Electrons\HtmlContents;

use App\Modules\Models\HtmlContent;
use App\Modules\Nucleons\Service;

class HtmlContentService extends Service
{
    /**
     * The main model for the service.
     *
     * @var HtmlContent
     */
    protected $model = HtmlContent::class;

    /**
     * Get multiple contents with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function multiple(array $params = [])
    {
        return $this->parseQueryString($this->getModel()->query(), $params)->get();
    }

    /**
     * Retrieve a content with the given name.
     *
     * @param  string  $name
     * @return HtmlContent
     */
    public function single($name)
    {
        return $this->multiple(['criteria' => 'name:=:'. $name])->first();
    }

    /**
     * Create a new content and return it.
     *
     * @param  array  $data
     * @return HtmlContent
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $content = HtmlContent::create($cleaned);

        return $content;
    }

    /**
     * Update a content with new data.
     *
     * @param  HtmlContent  $content
     * @param  array     $data
     * @return this
     */
    public function update(HtmlContent $content, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $content->{$field} = $value;
        }

        $content->save();

        return $this;
    }

    /**
     * Remove a content from the database.
     *
     * @param  HtmlContent  $content
     * @return this
     */
    public function remove(HtmlContent $content)
    {
        $content->delete();

        return $this;
    }
}
