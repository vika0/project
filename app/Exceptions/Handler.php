<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if($e instanceof HttpException && $e->getStatusCode()== 404)
        {
            return response()->json(['message' => 'Not Found!'], 404);
        }
        elseif($e instanceof HttpException && $e->getStatusCode()== 405)
        {
            return response()->json(['message' => '405!'], 405);
        }
        elseif($e instanceof HttpException && $e->getStatusCode()== 401)
        {
            return response()->json(['message' => '401!'], 401);
        }
        elseif($e instanceof HttpException && $e->getStatusCode()== 403)
        {
            return response()->json(['message' => '403!'], 403);
        }
         elseif($e instanceof ModelNotFoundException)
        {
            return response()->json(['message' => 'not found'], 404);
        }
    
        if ($e instanceof NotFoundHttpException) {
            return response()->json(['message' => 'Not Found!'], 404);
        }
        if ($e instanceof CustomException) {
            return response()->view('errors.custom', [], 500);
        }
        // // then the rest can go to a common page
    
            // return response()->json(['message' => 'nei vienas'], 404);
        //  return response()->view('errors.caught-errors', [
        //     'error' => 'Error encountered.',
        //     'description' => 'Brief public-friendly description.'
        // ]);
        // if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
        //     return response(view('error.404'), 404);
        //      return response()->json([
        //         'success' => false,
        //         'message' => 'Sorry, object wiannot be found'
        //     ], 400);

        if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(['success' => false,'message'=>'Token invalid'], 404);
        }
        if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(['success' => false,'message'=>'Token expired'], 404);
        }
        if($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
            return response()->json(['success' => false,'message'=>'No token given'], 404);
        }
        if($e instanceof \Illuminate\Database\QueryException) {
            return response()->json(['success' => false,'message'=>$e->getMessage()]);
        }


        // return parent::render($request, $e);
    }
}
