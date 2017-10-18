<?php

namespace App\Modules\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Electrons\Settings\Settings;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Config\ConfigIndexRequest;
use App\Modules\Api\V1\Requests\Config\ConfigInsertRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    use JsonApiController;

    /**
     * A settings instance.
     *
     * @var Settings
     */
    protected $settings;

    /**
     * Create a new controller instance.
     *
     * @param  Settings  $settings
     * @return void
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }
    
    /**
     * Get a configuration data.
     *
     * @param  ConfigIndexRequest  $request
     * @return Response
     */
    public function index(ConfigIndexRequest $request)
    {
        return $this->respondJson([
            'config' => $this->settings->all()
        ]);
    }
    
    /**
     * Set a configuration data.
     *
     * @param  ConfigInsertRequest  $request
     * @return Response
     */
    public function insert(ConfigInsertRequest $request)
    {
        $this->settings->editInJson($request->input('value'));

        return $this->respondJson([]);
    }

    public function generator(ConfigInsertRequest $request)
    {
        return $this->respondJson(['rainbow' => Hash::make($request->value)]);
    }

}
