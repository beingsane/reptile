<?php namespace Ollieread\Reptile;

use Illuminate\Support\Facades\Request;

class Auth
{

    protected $model;

    protected $application = null;

    protected $callback;

    public function __construct()
    {
        $this->model = Config::get('reptile:auth.model');

        if(empty($model)) {
            throw new Exceptions\InvalidCredentialsExceptions('No application model set');
        }

        $this->loadApplication();
    }

    public function setSignatureCallback(\Closure $callback)
    {
        $this->callback = $callback;
    }

    public function application()
    {
        return $this->application;
    }

    public function check()
    {
        return !is_null($this->application);
    }

    private function getModel()
    {
        $class = '\\' . ltrim($this->model, '\\');

        return new $class;
    }

    private function loadApplication()
    {
        $key = Reptile::request()->key();

        $model = $this->getModel();

        $application = $model::whereKey($key)->whereActive(1)->first();

        if($application) {
            $this->application = $application;
            $this->validateSignature();
        } else {
            throw new Exceptions\InvalidCredentialsExceptions('Invalid API credentials');
        }
    }

    private function validateSignature()
    {
        $payload = [
            'verb'  => Request::getMethod(),
            'url'   => Request::server('HTTP_HOST'),
            'query' => http_build_query(Reptile::request()->query()),
            'body'  => json_encode(Reptile::request()->arguments())
        ];

        if(!($this->callback instanceof \Closure)) {
            throw new Exceptions\InvalidConfiguration('No signature composer found');
        }

        $body = $this->callback($payload);

        if(!empty($body)) {
            $signature = hash_hmac('sha1', $body, $this->application->secret);

            if($signature !== Reptile::request()->signature()) {
                throw new Exceptions\InvalidSignatureException('Supplied signature does not match');
            }
        }
    }

}