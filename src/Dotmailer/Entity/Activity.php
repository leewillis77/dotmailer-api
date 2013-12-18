<?php

namespace Dotmailer\Entity;

/**
 * Contact activity summary.
 * http://api.dotmailer.com/v2/help/wadl#ApiCampaignContactSummary
 *
 * @extends Dotmailer\Entity
 */
class Activity extends Entity
{
    protected $contactId;
    protected $email;
    protected $numOpens;
    protected $numPageViews;
    protected $numClicks;
    protected $numForwards;
    protected $numReplies;
    protected $dateSent;
    protected $dateFirstOpened;
    protected $dateLastOpened;
    protected $firstOpenIp;
    protected $unsubscribed;
    protected $softBounced;
    protected $hardBounced;
}
