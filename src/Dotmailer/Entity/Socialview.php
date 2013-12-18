<?php

namespace Dotmailer\Entity;

/**
 * A social views record.
 * http://api.dotmailer.com/v2/help/wadl#ApiCampaignContactSocialBookmarkView
 *
 * @extends Dotmailer\Entity
 */
class Socialview extends Entity
{
    protected $contactId;
    protected $email;
    protected $bookmarkName;
    protected $numViews;
}
