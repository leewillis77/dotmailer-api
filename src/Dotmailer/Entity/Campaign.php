<?php

namespace Dotmailer\Entity;

/**
 * A campaign record.
 * http://api.dotmailer.com/v2/help/wadl#ApiCampaign
 *
 * @extends Dotmailer\Entity
 */
class Campaign extends Entity
{
    protected $id;
    public $name;
    public $subject;
    public $fromName;
    public $fromAddress;
    public $htmlContent;
    public $plainTextContent;
    public $replyAction;
    public $replyToAddress;
    public $isSplitTest;
    protected $status;
}
