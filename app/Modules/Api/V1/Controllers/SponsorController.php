<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Sponsor;
use App\Modules\Electrons\Edits\EditService;
use App\Modules\Electrons\Sponsors\SponsorService;
use App\Modules\Api\V1\Requests\Edits\EditIndexRequest;
use App\Modules\Api\V1\Requests\Sponsors\SponsorIndexRequest;
use App\Modules\Api\V1\Requests\Sponsors\SponsorInsertRequest;
use App\Modules\Api\V1\Requests\Sponsors\SponsorUpdateRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    use JsonApiController;

    /**
     * A sponsor service instance.
     *
     * @var SponsorService
     */
    protected $sponsors;

    /**
     * Create a new controller instance.
     *
     * @param  SponsorService  $sponsors
     * @return void
     */
    public function __construct(SponsorService $sponsors)
    {
        $this->sponsors = $sponsors;
    }

    /**
     * Get an array of sponsors data.
     *
     * @param  SponsorIndexRequest  $request
     * @return Response
     */
    public function index(SponsorIndexRequest $request)
    {
        return $this->respondJson(
            ['sponsors' => $this->sponsors->getMultiple($request->all())]
        );
    }

    /**
     * Get a sponsor data.
     *
     * @param  Request   $request
     * @param  Sponsor   $sponsor
     * @return Response
     */
    public function show(Request $request, Sponsor $sponsor)
    {
        return $this->respondJson(['sponsor' => $sponsor]);   
    }

    /**
     * Insert a new sponsor data.
     *
     * @param  SponsorInsertRequest  $request
     * @return Response
     */
    public function insert(SponsorInsertRequest $request)
    {
        $sponsor = $this->sponsors->create($request->all());

        return $this->respondJson(['sponsor' => $sponsor]);
    }

    /**
     * Update a sponsor data.
     *
     * @param  SponsorUpdateRequest  $request
     * @param  Sponsor               $sponsor
     * @return Response
     */
    public function update(SponsorUpdateRequest $request, Sponsor $sponsor)
    {
        $this->sponsors->update($sponsor, $request->all());

        return $this->respondJson(['sponsor' => $sponsor]);
    }

    /**
     * Delete a sponsor data.
     *
     * @param  Request   $request
     * @param  Sponsor   $sponsor
     * @return Response
     */
    public function remove(Request $request, Sponsor $sponsor)
    {
        $this->sponsors->remove($sponsor);

        return $this->respondJson(['sponsor' => $sponsor]);
    }

    /**
     * Get edits of the given sponsor.
     *
     * @param  EditIndexRequest   $request
     * @param  Sponsor            $sponsor
     * @param  EditService        $edits
     * @return Response
     */
    public function edits(EditIndexRequest $request, Sponsor $sponsor, EditService $edits)
    {
        $queries = $request->all();

        $queries['sponsor'] = $sponsor->id;

        return $this->respondJson(
            ['edits' => $edits->getMultiple($queries)]
        );
    }
}
