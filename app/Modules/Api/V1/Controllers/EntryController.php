<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Entry;
use App\Modules\Electrons\Activities\EntryService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Entries\EntryModifyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    use JsonApiController;

    /**
     * A entry service instance.
     *
     * @var EntryService
     */
    protected $entries;

    /**
     * Create a new controller instance.
     *
     * @param  EntryService  $entries
     * @return void
     */
    public function __construct(EntryService $entries)
    {
        $this->entries = $entries;
    }

    /**
     * Modify stage and status of an entry data.
     *
     * @param  EntryModifyRequest  $request
     * @param  Entry               $entry
     * @return Response
     */
    public function modify(EntryModifyRequest $request, Entry $entry)
    {
        $this->entries->modifyStage($entry, $request->input('stage', null))
                      ->modifyStatus($entry, $request->input('status', null));

        return $this->respondJson(['entry' => $entry]);
    }
}
