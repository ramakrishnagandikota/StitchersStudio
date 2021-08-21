<?php

namespace App\Exceptions;


//use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Mail;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use App\Mail\ExceptionOccured;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
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
     *
     * @throws \Exception
     */
    public function report(Throwable  $exception)
    {
        if ($this->shouldReport($exception) && env('ERROR_EXCEPTION_MAIL') == true) {
            $this->sendEmail($exception); // sends an email
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Throwable  $exception)
    {
        if ($exception instanceof TokenMismatchException){
            // Redirect to a form. Here is an example of how I handle mine
           return redirect($request->fullUrl())->with('csrf_error',"Oops! Seems you couldn't submit form for a long time. Please try again.");
            //auth()->logout();
            //return redirect('login');
        }
        return parent::render($request, $exception);
    }


    public function sendEmail(Throwable  $exception)
    {
        try {
            $e = FlattenException::create($exception);

            $handler = new SymfonyExceptionHandler();

            $html = $handler->getHtml($e);

            Mail::to('ramakrishna.gandikota@pluraltechnology.com')->send(new ExceptionOccured($html));
        } catch (Throwable $ex) {
            dd($ex);
        }
    }
}
