<?php namespace Ollieread\Reptile;

class Reptile
{

    protected $response;

    protected $request;

    protected $auth;

    protected $signature;

    public function __construct()
    {
        $this->response = new Response;
        $this->request = new Request;
        $this->auth = new Auth;
    }

    public function signature(\Closure $callback)
    {
        $this->auth->setSignatureCallback($callback);
    }

}