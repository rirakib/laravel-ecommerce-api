<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;

class ResponseController extends Controller
{
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function saveImage($folder,$image)
    {
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move($folder, $filename);

        return URL::to('/'.$folder.'/'.$filename);
    }

}
