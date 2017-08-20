<?php

namespace App\Web\Front\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\News\NewsService as Service;
use App\Modules\Models\News;

class NewsController extends Controller
{
    /**
     * The news service instance.
     *
     * @var Service
     */
    protected $service;

    /**
     * The cached news data.
     *
     * @var Collection
     */
    protected $cache;

    /**
     * The navigation theme.
     *
     * @var string
     */
    protected $navtheme = 'light';

    /**
     * The number of news to be taken.
     *
     * @var int
     */
    protected $take = 15;

    /**
     * Create a new controller instance.
     *
     * @param  Service  $service
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Show the news index page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->cacheNews();

        return view('front.news.index', $this->indexData(
            $request->query('p', 1)
        ));
    }

    /**
     * Show the news item page.
     *
     * @param  Request      $request
     * @param  News         $news
     * @param  string|null  $slug
     * @return Response
     */
    public function item(Request $request, News $news, $slug = null)
    {
        return view('front.news.item', $this->itemData($news));
    }

    /**
     * Cache the whole news data.
     *
     * @return void
     */
    protected function cacheNews()
    {
        $this->cache = $this->service->getMultiple(['sort' => 'created_at:desc']);
    }

    /**
     * Return the data required in the index view.
     *
     * @param  string  $page
     * @return array
     */
    protected function indexData($page)
    {
        return [
            'news' => $this->getNews($page),
            'page' => $this->getPages($page),
            'nav' => $this->navtheme,
        ];
    }

    /**
     * Get the required news.
     *
     * @param  string  $page
     * @return Collection
     */
    protected function getNews($page)
    {
        $skip = $this->take * ($page - 1);

        return $this->cache->slice($skip, $this->take);
    }

    /**
     * Get the possible pages.
     *
     * @param  string  $page
     * @return array
     */
    protected function getPages($page)
    {
        $possible = [];

        for ($i = 1; $i < ceil($this->cache->count() / $this->take); $i++) {
            $possible[] = $i;
        }

        return [
            'possible' => $possible,
            'current' => $page,
            'previous' => $page > 1 ? $page - 1 : null,
            'next' => $page < count($possible) ? $page + 1 : null,
        ];
    }

    /**
     * Return the data required in the item view.
     *
     * @param  News  $news
     * @return array
     */
    protected function itemData(News $news)
    {
        return [
            'news' => $news->load('edits.user'),
            'nav' => $this->navtheme,
        ];
    }

}
