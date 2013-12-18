<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Entity\Account;

class AccountRequest
{
    private $request;

    public function __construct(Config $config)
    {
        $this->request = new Request($config);
        $this->request->setEndpoint('account-info');
    }

    public function info()
    {
        $account = $this->request->send('get', '');
        if ($account) {
            return new Account($account);
        }
    }
}
