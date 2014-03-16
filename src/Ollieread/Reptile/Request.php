<?php namespace Ollieread\Reptile;

use Illuminate\Support\Facades\Request as LaravelRequest;

class Request
{

    protected $key;

    protected $signature;

    protected $arguments = [];

    protected $includes = [];

    protected $query = [];

    protected $count;

    protected $route;

    public function __construct()
    {
        $header = LaravelRequest::header('Authorization');
        $auth = explode(':', $header);

        if(count($auth) == 2) {
            list($this->key, $this->signature) = $auth;
        }

        $this->arguments = LaravelRequest::json()->all();

        $this->includes = explode(',', LaravelRequest::query('includes', ''));

        $this->count = LaravelRequest::query('count', 20);

        $this->query = LaravelRequest::query();

        $this->route = Route::current()->getName();
    }

    public function key()
    {
        return $this->key;
    }

    public function signature()
    {
        return $this->signature;
    }

    public function arguments($names = null, $required = false)
    {
        if(!$names) {
            return $this->arguments;
        } else {
            $arguments = [];

            foreach($names as $name) {
                $arguments[$name] = $this->argument($name, $required);
            }

            return $arguments;
        }
    }

    public function argumentsJson()
    {
        return json_encode($this->arguments);
    }

    public function argument($name, $required = false)
    {
        if(array_key_exists($name, $this->arguments)) {
            return $this->arguments[$name];
        } elseif($required == true) {
            throw new Exceptions\RequiredArgumentException('Missing required query parameter: ' . $name);
        }
    }

    public function shouldInclude($include)
    {
        return in_array($include, $this->includes);
    }

    public function includes()
    {
        return $this->includes;
    }

    public function query($name = null, $required = false) {
        if(is_null($name)) {
            return $this->query;
        }

        if(is_array($name)) {
            $query = [];

            foreach($name as $key) {
                if(array_key_exists($key, $this->query)) {
                    $query[$key] = $this->query[$key];
                } elseif($required == true) {
                    throw new Exceptions\RequiredArgumentException('Missing required query parameter: ' . $key);
                }
            }
        }
    }

    public function count()
    {
        return $this->count;
    }

}