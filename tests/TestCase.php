<?php

namespace Tests;

use App\Exceptions\Handler;
use TestHelper\ModelHelper;
// use Tests\HttpHelper;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $model;
    protected $httpHeaders;

    public function setUp(): void
    {
        parent::setUp();

        // $this->disableExceptionHandling();

        $this->model = new ModelHelper('App\Models');

        $user = $this->model->instance('User')->create();
       
        $this->be($user);

        // $this->httpHeaders = HttpHelper::bearerToken($user);
        $this->httpHeaders =  ['Authorization' => 'Bearer ' . $user->api_token];
    }

    /*
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {} 
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }
    */

    /*
    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    } 
    */

}
