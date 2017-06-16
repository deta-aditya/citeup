<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\News;
use App\Modules\Electrons\News\NewsService;
use App\Modules\Api\V1\Requests\News\NewsIndexRequest;
use App\Modules\Api\V1\Requests\News\NewsInsertRequest;
use App\Modules\Api\V1\Requests\News\NewsUpdateRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    use JsonApiController;

    /**
     * A news service instance.
     *
     * @var NewsService
     */
    protected $news;

    /**
     * Create a new controller instance.
     *
     * @param  NewsService  $news
     * @return void
     */
    public function __construct(NewsService $news)
    {
        $this->news = $news;
    }

    /**
     * Get an array of news data.
     *
     * @param  NewsIndexRequest  $request
     * @return Response
     */
    public function index(NewsIndexRequest $request)
    {
        return $this->respondJson(
            ['news' => $this->news->getMultiple($request->all())]
        );
    }

    /**
     * Get a news data.
     *
     * @param  Request   $request
     * @param  News      $news
     * @return Response
     */
    public function show(Request $request, News $news)
    {
        return $this->respondJson(['news' => $news]);   
    }

    /**
     * Insert a new news data.
     *
     * @param  NewsInsertRequest  $request
     * @return Response
     */
    public function insert(NewsInsertRequest $request)
    {
        $news = $this->news->create($request->all());

        return $this->respondJson(['news' => $news]);
    }

    /**
     * Update a news data.
     *
     * @param  NewsUpdateRequest  $request
     * @param  News               $news
     * @return Response
     */
    public function update(NewsUpdateRequest $request, News $news)
    {
        $this->news->update($news, $request->all());

        return $this->respondJson(['news' => $news]);
    }

    /**
     * Delete a news data.
     *
     * @param  Request   $request
     * @param  News  $news
     * @return Response
     */
    public function remove(Request $request, News $news)
    {
        $this->news->remove($news);

        return $this->respondJson(['news' => $news]);
    }
}
