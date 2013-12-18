<?php

namespace Dotmailer\Entity;

/**
 * A reply record.
 * http://api.dotmailer.com/v2/help/wadl#ApiCampaignContactReply
 *
 * @extends Dotmailer\Entity
 */
class Reply extends Entity
{
    protected $contactId;
    protected $email;
    protected $fromAddress;
    protected $toAddress;
    protected $subject;
    protected $message;
    protected $isHtml;
    protected $dateReplied;
    protected $replyType;
}
