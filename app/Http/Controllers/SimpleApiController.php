<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yaml;

class SimpleApiController extends Controller {

    /**
     * Get api options
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptions() {
        $response = array(
            array(
                'method' => 'OPTIONS',
                'url' => '/api',
                'description' => 'Get this options'
            ),
            array(
                'method' => 'GET',
                'url' => '/api/urls',
                'description' => 'Get all server response data'
            ),
            array(
                'method' => 'GET',
                'url' => '/api/urls/{$id}',
                'description' => 'Get specific server response data'
            )
        );
        return response()->json($response, 200);
    }

    /**
     * Get all resources.
     * @param type $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllResources() {
        $serverResponses = \App\ServerResponse::all();

        if ($serverResponses->count() > 0) {
            $status = 200;
        } else {
            $status = 204;
        }

        return response()->json($serverResponses, $status);
    }

    /**
     * Get specific resource.
     * @param type $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResource($id) {
        $serverResponse = \App\ServerResponse::find($id);

        if (empty($serverResponse)) {
            $status = 204;
        } else {
            $status = 200;
        }

        return response()->json($serverResponse, $status);
    }

}
