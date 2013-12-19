<?php

namespace Dotmailer\Entity;

/**
 * An ROI record.
 * http://api.dotmailer.com/v2/help/wadl#ApiCampaignContactRoiDetail
 *
 * @extends Dotmailer\Entity
 */
class Roi extends Entity
{
    protected $contactId;
    protected $email;
    protected $markerName;
    protected $dataType;
    protected $value;
    protected $dateEntered;
}
