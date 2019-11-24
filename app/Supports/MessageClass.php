<?php

namespace App\Supports;

trait MessageClass
{

    /**
     * sendBadRequest => called when api response sending
     *
     * @param  mixed $returnArray => response data , default null
     * @param  mixed $returnMessage => response message
     * @param  mixed $statusCode => status message
     *
     * @return void
     */
    public function sendBadRequest($returnArray = null, $returnMessage, $statusCode = RESPONSE_BAD_REQUEST)
    {
        $response = [
            'success' => false,
            'status' => $statusCode,
            'data' => null,
            'message' => is_string($returnMessage) ? ucfirst(strtolower($returnMessage)) : $returnMessage
        ];
        return response()->json($response);
    }

    /**
     * sendSuccessResponse
     *
     * @param  mixed $returnArray => Response data
     * @param  mixed $returnMessage => return message
     * @param  mixed $statusCode => return status default is 200
     *
     * @return void
     */
    public function sendSuccessResponse($returnArray = null, $returnMessage, $statusCode = RESPONSE_CODE_SUCCESS)
    {
        $response = [
            'success' => true,
            'status' => $statusCode,
            'data' => $returnArray ?? null,
            'message' => ucfirst(strtolower($returnMessage))
        ];
        return response()->json($response);
    }

    /**
     * makeResponse => called for inner functions only
     *
     * @param  mixed $array
     * @param  mixed $returnMessage
     *
     * @return void
     */
    public function makeResponse($array = null, $returnMessage)
    {
        $response = [
            'data' => $array,
            'message' => $returnMessage ?? '',
            'flag' => true
        ];
        return $response;
    }

    /**
     * makeError => called for inner functions only
     *
     * @param  mixed $array
     * @param  mixed $returnMessage
     *
     * @return void
     */
    public function makeError($array = null, $returnMessage)
    {
        return [
            'flag' => false,
            'data' => $array ?? null,
            'message' => $returnMessage ?? '',
        ];
    }
}
