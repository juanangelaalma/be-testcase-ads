<?php

namespace App\Services;

class ApiResponseService {
  public static function success($data = null, $message = null, $code = 200) {
    return response([
      'success' => true,
      'data' => $data,
      'message' => $message,
      'error' => null
    ], $code);
  }

  public static function error($error = null, $message = null, $code = 500) {
    return response([
      'success' => false,
      'data' => null,
      'message' => $message,
      'error' => $error,
    ], $code);
  }
}
