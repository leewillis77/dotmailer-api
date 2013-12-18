<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Collection\TemplateCollection;
use Dotmailer\Entity\Template;

class TemplateRequest
{
    private $request;

    public function __construct(Config $config)
    {
        $this->request = new Request($config);
        $this->request->setEndpoint('templates');
    }

    private function findId($template)
    {
        if (is_scalar($template)) {
            $template_id = $template;
        } elseif (is_object($template)) {
            $template_id = $template->id;
        } else {
            throw new Exception('Invalid template reference.');
        }
        return $template_id;

    }

    public function getAll($args = array())
    {
        $this->request->setArgs($args);
        $templates = $this->request->send('get', '');
        if (count($templates)) {
            return new TemplateCollection($templates);
        } else {
            return $templates;
        }
    }

    public function get($template)
    {
        return new Template($this->request->send('get', '/' . $this->findId($template)));
    }

    public function create($template)
    {
        return new Template($this->request->send('post', '', $template)); // FIXME - not working
    }

    public function update($template)
    {
        return new Template($this->request->send('put', '/' . $this->findId($template), $template)); // FIXME - not working
    }
}
