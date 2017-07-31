<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Alert;
use App\Modules\Electrons\Alerts\AlertService;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Alerts\AlertIndexRequest;
use App\Modules\Api\V1\Requests\Alerts\AlertShowRequest;
use App\Modules\Api\V1\Requests\Alerts\AlertInsertRequest;
use App\Modules\Api\V1\Requests\Alerts\AlertUpdateRequest;
use App\Modules\Api\V1\Requests\Alerts\AlertDeleteRequest;
use App\Modules\Api\V1\Requests\Alerts\AnnounceAlertRequest;
use App\Modules\Api\V1\Requests\Users\UserIndexRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    use JsonApiController;

    /**
     * A alert service instance.
     *
     * @var AlertService
     */
    protected $alerts;

    /**
     * Create a new controller instance.
     *
     * @param  AlertService  $alerts
     * @return void
     */
    public function __construct(AlertService $alerts)
    {
        $this->alerts = $alerts;
    }

    /**
     * Get an array of alerts data.
     *
     * @param  AlertIndexRequest  $request
     * @return Response
     */
    public function index(AlertIndexRequest $request)
    {
        return $this->respondJson(
            ['alerts' => $this->alerts->getMultiple($request->all())]
        );
    }

    /**
     * Get an alert data.
     *
     * @param  AlertShowRequest  $request
     * @param  Alert    $alert
     * @return Response
     */
    public function show(AlertShowRequest $request, Alert $alert)
    {
        return $this->respondJson(['alert' => $alert]);   
    }

    /**
     * Insert a new alert data.
     *
     * @param  AlertInsertRequest  $request
     * @return Response
     */
    public function insert(AlertInsertRequest $request)
    {
        $alert = $this->alerts->create($request->all());

        $this->alerts->announceMultiple($request->input('users', []), [$alert->id]);

        return $this->respondJson(['alert' => $alert]);
    }

    /**
     * Update an alert data.
     *
     * @param  AlertUpdateRequest  $request
     * @param  Alert               $alert
     * @return Response
     */
    public function update(AlertUpdateRequest $request, Alert $alert)
    {
        $this->alerts->update($alert, $request->all());

        return $this->respondJson(['alert' => $alert]);
    }

    /**
     * Delete an alert data.
     *
     * @param  AlertDeleteRequest  $request
     * @param  Alert    $alert
     * @return Response
     */
    public function remove(AlertDeleteRequest $request, Alert $alert)
    {
        $this->alerts->remove($alert);

        return $this->respondJson(['alert' => $alert]);
    }

    /**
     * Get users who were announced the given alert.
     *
     * @param  UserIndexRequest  $request
     * @param  Alert             $alert
     * @param  UserService       $users
     * @return Response 
     */
    public function users(UserIndexRequest $request, Alert $alert, UserService $users)
    {
        $queries = $request->all();

        return $this->respondJson(
            ['users' => $users->getMultipleCustomQuery($alert->users()->getQuery(), $queries)]
        );
    }

    /**
     * Announce or unannounce an alert to users.
     *
     * @param  AnnounceAlertRequest  $request
     * @param  Alert                 $alert
     * @return Response
     */
    public function announceUsers(AnnounceAlertRequest $request, Alert $alert)
    {
        $this->alerts->announceMultiple($request->input('announce', []), [$alert->id]);

        $this->alerts->unannounceMultiple($request->input('unannounce', []), [$alert->id]);

        return $this->respondJson(['users' => $alert->users]);
    }
}
