<?php namespace Ollieread\Reptile\Exceptions;

class ReptileException extends \Exception
{

    protected $type;

    protected $http;

    public function __construct($message, \Exception $previous = null)
    {
        $config = Config::get('reptile:response.' . $this->type);

        parent::__construct($message, $config['code'], $previous);

        $this->http = $config['http'];
    }

    public function getHttp()
    {
        return $this->http;
    }

}