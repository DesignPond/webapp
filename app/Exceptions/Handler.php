<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
        if ($e instanceof \App\Exceptions\UpdateFailException)
            return \Redirect::back()->with(array('status' => 'danger' , 'message' => 'Veuillez indiquer les informations pour l\'adresse temporaire'))->withInput();

        if ($e instanceof \App\Exceptions\ActivationFailException)
            \Log::info('Problème avec l\'activation du compte', ['token' => $e->getToken()]);

		return parent::render($request, $e);
	}

}
