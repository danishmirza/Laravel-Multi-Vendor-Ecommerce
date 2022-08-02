<?php

namespace App\Exceptions;


use App\Libraries\ResponseBuilder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [

    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)){
            if ($exception->getStatusCode() == 404)
                return redirect()->guest('/404');
            if ($exception->getStatusCode() == 500)
                return redirect()->guest('/');
        }
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->route('web.front.index');
        }

        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException)  {
            return $this->unauthorized($request, $exception);
        }

        // findOrFail Exception handler
        if ($request->expectsJson() && $exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return (new ResponseBuilder(400, __('Bad request')))->build();
        }

        if ($request->expectsJson() && $exception instanceof \Illuminate\Validation\ValidationException) {
            $errors = $exception->validator->errors()->getMessages();
            $firstErrorMessage = arr::first($errors);
            $response = ['success' => false, 'message' => $firstErrorMessage[0], 'data' => new \stdClass(), 'errors' => []];
            foreach ($errors as $inputName => $messages) {
                $response['errors'][$inputName] = [
                    'hasError' => true,
                    'message' => arr::first($messages)
                ];
            }
            return response($response);
        }
//         convert remainging all Exception into JSON formate
        if ($request->expectsJson()) {
            return (new ResponseBuilder(422, (($exception->getMessage()) ? $exception->getMessage() : __('Something Went Wrong'))))->build();
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return (new ResponseBuilder(401, __('Unauthenticated')))->build();
        }
        $guard = arr::get($exception->guards(), 0);
        switch ($guard) {
            case 'admin':
                $login = 'admin.auth.login.form';
                break;
            default:
                $login = 'web.auth.login';
                break;
        }
        return redirect()->guest(route($login))->with('err', 'You are not authorised to perform this action');
    }

    protected function unauthorized($request, AuthorizationException $exception)
    {
        if ($request->expectsJson()) {
            return (new ResponseBuilder(403, __($exception->getMessage()), [ 'clearCart' => true]))->build();
        }
        if($exception->getCode() == 601){
            return redirect()->back()->withInput()->with(['err' => $exception->getMessage(), 'clearCart' => true]);
        }
        return redirect()->back()->withInput()->with('err', $exception->getMessage());
    }
}
