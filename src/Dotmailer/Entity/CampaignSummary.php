<?php

namespace Dotmailer\Entity;

/**
 * A campaign summary record.
 * http://api.dotmailer.com/v2/help/wadl#ApiCampaignSummary
 *
 * @extends Dotmailer\Entity
 */
class CampaignSummary extends Entity
{
    protected $dateSent;
    protected $numUniqueOpens;
    protected $numUniqueTextOpens;
    protected $numTotalUniqueOpens;
    protected $numOpens;
    protected $numTextOpens;
    protected $numTotalOpens;
    protected $numClicks;
    protected $numTextClicks;
    protected $numTotalClicks;
    protected $numPageViews;
    protected $numTotalPageViews;
    protected $numTextPageViews;
    protected $numForwards;
    protected $numTextForwards;
    protected $numEstimatedForwards;
    protected $numTextEstimatedForwards;
    protected $numTotalEstimatedForwards;
    protected $numReplies;
    protected $numTextReplies;
    protected $numTotalReplies;
    protected $numHardBounces;
    protected $numTextHardBounces;
    protected $numTotalHardBounces;
    protected $numSoftBounces;
    protected $numTextSoftBounces;
    protected $numTotalSoftBounces;
    protected $numUnsubscribes;
    protected $numTextUnsubscribes;
    protected $numTotalUnsubscribes;
    protected $numIspComplaints;
    protected $numTextIspComplaints;
    protected $numTotalIspComplaints;
    protected $numMailBlocks;
    protected $numTextMailBlocks;
    protected $numTotalMailBlocks;
    protected $numSent;
    protected $numTextSent;
    protected $numTotalSent;
    protected $numRecipientsClicked;
    protected $numDelivered;
    protected $numTextDelivered;
    protected $numTotalDelivered;
    protected $percentageDelivered;
    protected $percentageUniqueOpens;
    protected $percentageOpens;
    protected $percentageUnsubscribes;
    protected $percentageReplies;
    protected $percentageHardBounces;
    protected $percentageSoftBounces;
    protected $percentageUsersClicked;
    protected $percentageClicksToOpens;
}
