<?php

namespace Tests;

// use Tests\HttpHelper;
use App\Exceptions\Handler;
use TestHelper\ModelHelper;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $model;
    protected $httpHeaders;
    protected $url;    

    public function setUp(): void
    {
        parent::setUp();

        $this->model = new ModelHelper('App\Models');

        $user = $this->model->instance('User')->create();
       
        $this->be($user);

        // $this->httpHeaders = HttpHelper::bearerToken($user);
        $this->httpHeaders =  ['Authorization' => 'Bearer ' . $user->api_token];
     
    }
}
