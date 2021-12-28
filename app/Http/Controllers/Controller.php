<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Возвращаем ошибку для исключений в json
     *
     * @param \Exception $exception
     * @param int $status
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function jsonException(\Exception $exception, $status = 400)
    {
        Log::error(implode("\n", [
            $exception->getMessage() . ' In ' . $exception->getFile() . ' on line ' . $exception->getLine(),
            $exception->getTraceAsString(),
        ]));
        return response([
            'title' => 'Ошибка обработки',
            'message' => $exception->getMessage() . ' In ' . $exception->getFile() . ' on line ' . $exception->getLine(),
        ], $status);
    }
}
