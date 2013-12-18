<?php

namespace Dotmailer\Request;

use Guzzle\Http\Client;
use Dotmailer\Config;
use Dotmailer\Exception;

class Request
{
    private $client;
    private $args;
    protected $endpoint = 'https://api.dotmailer.com/v2/';

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = new Client();
        $this->client->setDefaultOption(
            'auth',
            array(
                $config->username,
                $config->password,
           )
        );
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint .= $endpoint;
    }

    public function setArgs($args)
    {
        $this->args = $args;
    }

    public function send($method, $path, $data = null)
    {
        switch($method) {
            case 'get':
                return $this->get($path);
            break;
            case 'post':
                return $this->post($path, $data);
            break;
            case 'delete':
                return $this->delete($path);
            break;
            case 'put':
                return $this->put($path, $data);
            break;
            default:
                throw new \Exception('Invalid request type');
        }
    }

    private function get($path)
    {
        $request = $this->client->get($this->endpoint . $path);
        $this->applyArgs($request);
        return $this->doSend($request);
    }

    private function delete($path)
    {
        $request = $this->client->delete($this->endpoint . $path);
        $this->applyArgs($request);
        return $this->doSend($request);
    }

    private function put($path, $data)
    {
        $request = $this->client->put($this->endpoint . $path);
        $request->setBody(json_encode($data), 'application/json');
        return $this->doSend($request);
    }

    private function post($path, $data)
    {
        $request = $this->client->post($this->endpoint . $path);
        $request->setBody(json_encode($data), 'application/json');
        return $this->doSend($request);
    }

    private function applyArgs($request)
    {
        if (!count($this->args)) {
            return;
        }
        foreach ($this->args as $key => $value) {
            if ($value === null) {
                return;
            }
            $query = $request->getQuery();
            $query->set($key, $value);
        }
    }

    private function doSend($request)
    {
        try {
            $response = $request->send();
        } catch (\Guzzle\Http\Exception\BadResponseException $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e, $e->getResponse());
        }
        if ($response->isSuccessful()) {
            $body = $response->getBody();
            $body = json_decode($body);
            return $body;
        } else {
            throw new Exception('Unexpected API response', 0, null, $response);
        }
    }

    private function maybeAddDate($date_string, $slug, $path)
    {
        if (empty($date_string)) {
            return $path;
        }
        $valid_date_str = $this->formatDate($date_string);
        return $path . $slug . $date_string;
    }

    private function formatDate($date_string)
    {
        try {
            $date = \DateTime($date_string);
        } catch ( \Exception $e) {
            throw new Exception("Invalid date format : $date_string");
        }
        return $date->format(\DateTime::ISO8601);
    }
}
