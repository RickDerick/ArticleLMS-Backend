<?php


namespace App\Http\Controllers\Concerns;


use Illuminate\Http\JsonResponse;

trait ApiResponder
{

    /**
     * STATUS CODES REFERENCE
     * OK = 200;
     * CREATED = 201;
     * ACCEPTED = 202;
     * NO_CONTENT = 204;
     * PARTIAL_CONTENT = 206;
     * MOVED = 301;
     * OTHER = 303;
     * UNMODIFIED = 304;
     * REDIRECT = 307;
     * BAD = 400;
     * UNAUTHORIZED = 401;
     * FORBIDDEN = 403;
     * NOTFOUND = 404;
     * GONE = 410;
     * ERROR = 500;
     * UNAVAILABLE = 503;
     * */


    /**
     * @param null $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function success($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * @param string|null $message
     * @param int $code
     * @param null $data
     * @return JsonResponse
     */
    protected function error(string $message = null, int $code = 500, $data = null): JsonResponse
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return JsonResponse
     * @throws \Exception
     */
    protected function exception($message, $code = 422): JsonResponse
    {
        if ($message instanceof \Exception)
            throw $message;

        return $this->error($message, $code);
    }

}
