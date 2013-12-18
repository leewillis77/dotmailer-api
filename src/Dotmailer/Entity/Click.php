<?php

namespace Dotmailer\Entity;

/**
 * A click record.
 * http://api.dotmailer.com/v2/help/wadl#ApiCampaignContactClick
 *
 * @extends Dotmailer\Entity
 */
class Click extends Entity
{
    protected $contactId;
    protected $email;
    protected $url;
    protected $ipAddress;
    protected $userAgent;
    protected $dateClicked;
    protected $keyword;
}
