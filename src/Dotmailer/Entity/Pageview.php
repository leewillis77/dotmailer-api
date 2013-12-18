<?php

namespace Dotmailer\Entity;

/**
 * A pageview record.
 * http://api.dotmailer.com/v2/help/wadl#ApiCampaignContactPageView
 *
 * @extends Dotmailer\Entity
 */
class Pageview extends Entity
{
    protected $contactId;
    protected $email;
    protected $url;
    protected $dateViewed;
}
