<?php

namespace Dotmailer\Entity;

/**
 * An open record.
 * http://api.dotmailer.com/v2/help/wadl#ApiCampaignContactOpen
 *
 * @extends Dotmailer\Entity
 */
class Open extends Entity
{
    protected $contactId;
    protected $email;
    protected $mailClient;
    protected $mailClientVersion;
    protected $ipAddress;
    protected $userAgent;
    protected $isHtml;
    protected $isForward;
    protected $dateOpened;
}
