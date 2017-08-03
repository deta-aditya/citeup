<?php

namespace App\Modules\Electrons\News;

use App\Modules\Models\News;
use App\Modules\Nucleons\Service;

class NewsService extends Service
{
    /**
     * The URL to the default picture.
     *
     * @var string
     */
    protected $defaultPicture = 'images/default.jpg';

    /**
     * The main model for the service.
     *
     * @var News
     */
    protected $model = News::class;

    /**
     * Get multiple news with conditions.
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
     * Create a new news and return it.
     *
     * @param  array  $data
     * @return News
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        if (! array_has($cleaned, 'picture')) {
            $cleaned['picture'] = $this->defaultPicture;
        }

        $news = News::create($cleaned);

        return $news;
    }

    /**
     * Update a news with new data.
     *
     * @param  News   $news
     * @param  array  $data
     * @return this
     */
    public function update(News $news, array $data)
    {
        $cleaned = $this->clean($data);

        foreach ($cleaned as $field => $value) {
            $news->{$field} = $value;
        }

        $news->save();

        return $this;
    }

    /**
     * Remove a news from the database.
     *
     * @param  News  $news
     * @return this
     */
    public function remove(News $news)
    {
        $news->delete();

        return $this;
    }
}
