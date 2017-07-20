<?php

namespace App\Modules\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Electrons\Config\Config;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Config\ConfigIndexRequest;
use App\Modules\Api\V1\Requests\Config\ConfigInsertRequest;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    use JsonApiController;

    /**
     * A storage service instance.
     *
     * @var Config
     */
    protected $config;

    /**
     * Create a new controller instance.
     *
     * @param  Config  $config
     * @return void
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
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
            'config' => $this->config->get(
                $request->input('path'), $this->config->all()
            )
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
        $this->config->set(
            $this->config->decode($request->input('value')
        ));

        return $this->respondJson([]);
    }

}
