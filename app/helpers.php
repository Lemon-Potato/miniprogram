<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 2020/7/31
 * Time: 10:50 PM
 */


if (!function_exists('responseSuccess')) {
    /**
     * Success response
     * @param array|LengthAwarePaginator $data
     * @param string $msg
     * @param array $other
     * @return JsonResponse
     */
    function responseSuccess($data = [], $msg = '操作成功', $other = [])
    {
        $res = [
            'message' => $msg,
            'data' => $data,
            'code' => 200,
        ];

        $res = !empty($other) ? array_merge($res, $other) : $res;
        if ($data instanceof LengthAwarePaginator) {
            $data = $data->toArray();
            $page = [
                'current_page' => (int)$data['current_page'],
                'last_page' => (int)$data['last_page'],
                'per_page' => (int)$data['per_page'],
                'total' => (int)$data['total'],
            ];

            $res['data'] = $data['data'];
            $res['count'] = (int)$data['total'];
            $res['pages'] = $page;
        }

        return response()->json($res);
    }
}

if (!function_exists('responseFailed')) {
    /**
     * Error response
     * @param string $msg
     * @param integer $statusCode
     * @param array $data
     * @return JsonResponse
     */
    function responseFailed($msg = '操作失败', $statusCode = 400, $data = [])
    {
        if (config('app.debug')) {
            return response()->json([
                'message' => $msg,
                'data' => $data,
            ])->setStatusCode($statusCode);
        }

        return response()->json([
            'message' => $msg,
            'data' => $data,
        ])->setStatusCode($statusCode);
    }
}