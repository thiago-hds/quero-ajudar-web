<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
/**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($data)
    {
    	$response = [
            'status'  => 'success',
            'data'    => $data
        ];


        return response()->json($response);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendFail($message = '', $data = [])
    {
    	$response = [
            'status'    => 'fail',
            'message'   => $message
        ];

        if(!empty($data)){
            $response['data'] = $data;
        }

        return response()->json($response, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($message)
    {
    	$response = [
            'status' => 'error',
            'message' => $message
        ];

        return response()->json($response);
    }
}
