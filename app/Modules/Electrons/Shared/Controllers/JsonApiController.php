<?php

namespace App\Modules\Electrons\Shared\Controllers;

trait JsonApiController 
{
    /**
     * Respond a success in JSON.
     *
     * @param  array  $data
     * @return Response
     */
    public function respondJson(array $data)
    {
        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }
}
