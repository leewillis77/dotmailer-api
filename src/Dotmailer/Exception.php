<?php

namespace Dotmailer;

class Exception extends \Exception
{
    private $failure_type;
    private $response;

    public function __construct($message = null, $code = 0, $previous = null, $response = null)
    {
        parent::__construct($message, $code, $previous);
        if (empty($previous)) {
            $this->failure_type = 'api';
        } else {
            $this->failure_type = 'transport';
        }
        if (!empty($response)) {
            $this->response = $response;
        }
    }

    public function __get($key)
    {
        if ($key == 'failure_type') {
            return $this->failure_type;
        }
        if ($key == 'api_code') {
            if (!empty($this->response)) {
                return $this->response->getStatusCode();
            } else {
                return null;
            }
        }
        if ($key == 'api_msg') {
            if (!empty($this->response)) {
                return $this->response->getMessage();
            } else {
                return null;
            }
        }
        if ($key == 'api_response') {
            if (!empty($this->response)) {
                $body = json_decode($this->response->getBody());
                
                if (!$body || !isset($body->message)) {
                    return null;
                }
                
                return $body->message;
            } else {
                return null;
            }
        }
        if ($key == 'raw_api_response') {
            if (!empty($this->response)) {
                return $this->response->getBody();
            } else {
                return null;
            }
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );
        return null;
    }
}
