<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Collection\ActivityCollection;
use Dotmailer\Collection\AddressbookCollection;
use Dotmailer\Collection\CampaignCollection;
use Dotmailer\Collection\ClickCollection;
use Dotmailer\Collection\DocumentCollection;
use Dotmailer\Collection\OpenCollection;
use Dotmailer\Collection\PageviewCollection;
use Dotmailer\Collection\ReplyCollection;
use Dotmailer\Collection\RoiCollection;
use Dotmailer\Collection\SocialviewCollection;
use Dotmailer\Entity\Activity;
use Dotmailer\Entity\Campaign;
use Dotmailer\Entity\CampaignSummary;

class CampaignRequest
{
    private $request;

    public function __construct(Config $config)
    {
        $this->request = new Request($config);
        $this->request->setEndpoint('campaigns');
    }

    /**
     * Helper function to extract an ID given an ID, or object.
     *
     * @param  int|Entity $object An int, or a Dotmailer entity object.
     * @return int                The ID of the passed object.
     */
    private function findId($object)
    {
        if (is_int($object)) {
            $object_id = $object;
        } elseif (is_object($object)) {
            $object_id = $object->id;
        } else {
            throw new Exception('Invalid reference.');
        }
        return $object_id;
    }

    public function getContactActivity($campaign_id, $contact_id)
    {
        $activity = $this->request->send('get', '/' . $campaign_id . '/activities/' . $contact_id);
        if ($activity) {
            return new Activity($activity);
        } else {
            return $activity;
        }
    }

    public function getContactActivityClicks($campaign_id, $contact_id, $args = array())
    {
        $this->request->setArgs($args);
        $clicks = $this->request->send('get', '/' . $campaign_id . '/activities/' . $contact_id . '/clicks');
        if (count($clicks)) {
            return new ClickCollection($clicks);
        } else {
            return $clicks;
        }
    }

    public function getContactActivityOpens($campaign_id, $contact_id, $args = array())
    {
        $this->request->setArgs($args);
        $opens = $this->request->send('get', '/' . $campaign_id . '/activities/' . $contact_id . '/opens');
        if (count($opens)) {
            return new OpenCollection($opens);
        } else {
            return $opens;
        }
    }

    public function getContactActivityPageviews($campaign_id, $contact_id, $args = array())
    {
        $this->request->setArgs($args);
        $pageviews = $this->request->send('get', '/' . $campaign_id . '/activities/' . $contact_id . '/page-views');
        if (count($pageviews)) {
            return new PageviewCollection($pageviews);
        } else {
            return $pageviews;
        }
    }

    public function getContactActivityReplies($campaign_id, $contact_id, $args = array())
    {
        $this->request->setArgs($args);
        $replies = $this->request->send('get', '/' . $campaign_id . '/activities/' . $contact_id . '/replies');
        if (count($replies)) {
            return new ReplyCollection($replies);
        } else {
            return $replies;
        }
    }

    public function getContactActivityRoi($campaign_id, $contact_id, $args = array())
    {
        $this->request->setArgs($args);
        $roi = $this->request->send('get', '/' . $campaign_id . '/activities/' . $contact_id . '/roi-details');
        if (count($roi)) {
            return new RoiCollection($roi);
        } else {
            return $roi;
        }
    }

    public function getContactActivitySocialviews($campaign_id, $contact_id, $args = array())
    {
        $this->request->setArgs($args);
        $socialviews = $this->request->send(
            'get',
            '/' . $campaign_id . '/activities/' . $contact_id . '/social-bookmark-views'
        );
        if (count($socialviews)) {
            return new SocialviewCollection($socialviews);
        } else {
            return $socialviews;
        }
    }

    public function getActivity($campaign_id, $date = null, $args = array())
    {
        $path = '/' . $campaign_id . '/activities';
        $path = maybeAddDate($date, '/since-date/', $path);
        $this->request->setArgs($args);
        $activity = $this->request->send('get', $path);
        if ($activity) {
            return new ActivityCollection($activity);
        } else {
            return $activity;
        }
    }

    public function getAddressbooks($campaign_id, $args = array())
    {
        $this->request->setArgs($args);
        $books = $this->request->send('get', '/' . $campaign_id . '/address-books');
        if (count($books)) {
            return new AddressbookCollection($books);
        } else {
            return $books;
        }
    }

    public function getActivityClicks($campaign_id, $args = array())
    {
        $this->request->setArgs($args);
        $clicks = $this->request->send('get', '/' . $campaign_id . '/clicks');
        if (count($clicks)) {
            return new ClickCollection($clicks);
        } else {
            return $clicks;
        }
    }

    public function getActivityOpens($campaign_id, $args = array())
    {
        $this->request->setArgs($args);
        $opens = $this->request->send('get', '/' . $campaign_id . '/opens');
        if (count($opens)) {
            return new OpenCollection($opens);
        } else {
            return $opens;
        }
    }

    public function getPageviews($campaign_id, $date, $args = array())
    {
        $path = '/' . $campaign_id . '/page-views';
        $path = maybeAddDate($date, '/since-date/', $path);
        $this->request->setArgs($args);
        $pageviews = $this->request->send('get', $path);
        if (count($pageviews)) {
            return new PageviewCollection($pageviews);
        } else {
            return $pageviews;
        }
    }

    public function getRoi($campaign_id, $date, $args = array())
    {
        $path = '/' . $campaign_id . '/roi-details';
        $path = maybeAddDate($date, '/since-date/', $path);
        $this->request->setArgs($args);
        $roi = $this->request->send('get', $path);
        if (count($roi)) {
            return new RoiCollection($roi);
        } else {
            return $roi;
        }
    }

    public function getSocialviews($campaign_id, $args = array())
    {
        $path = '/' . $campaign_id . '/social-bookmark-views';
        $this->request->setArgs($args);
        $socialviews = $this->request->send('get', $path);
        if (count($socialviews)) {
            return new SocialviewCollection($socialviews);
        } else {
            return $socialviews;
        }
    }

    public function getSummary($campaign_id)
    {
        $summary = $this->request->send('get', '/' . $campaign_id . '/summary');
        if (count($summary)) {
            return new CampaignSummary($summary);
        } else {
            return $summary;
        }
    }

    public function get($campaign_id)
    {
        $campaign = $this->request->send('get', '/' . $campaign_id);
        if (count($campaign)) {
            return new Campaign($campaign);
        } else {
            return $campaign;
        }
    }

    /**
     * Gets documents that are currently attached to a campaign.
     * https://api.dotmailer.com/v2/campaigns/{campaignId}/attachments
     *
     * @param  int|Campaign         $campaign The campaign to retrieve documents from.
     * @return DocumentCollection           A list of the matching attachments.
     */
    public function getDocuments($campaign)
    {
        $documents = $this->request->send('get', '/' . $this->findId($campaign) . '/attachments');
        if (count($documents)) {
            return new DocumentCollection($documents);
        } else {
            return $documents;
        }
    }

    /**
     * Add a document to a campaign.
     * https://api.dotmailer.com/v2/campaigns/{campaignId}/attachments
     *
     * @param int|Campaign $campaign The campaign to add the document to.
     * @param Document     $document The document to add.
     */
    public function addDocument($campaign, $document)
    {
        $document = $this->request->send(
            'post',
            '/' . $this->findId($campaign) . '/attachments',
            $document
        );
        return new Document($document);
    }

    /**
     * Delete a document from a campaign.
     * https://api.dotmailer.com/v2/campaigns/{campaignId}/attachments/{documentId}
     *
     * @param int|Campaign $campaign The campaign to remove the document from.
     * @param int|Document $document The document to remove.
     */
    public function deleteDocument($campaign, $document)
    {
        $document = $this->request->send(
            'delete',
            '/' . $this->findId($campaign) . '/attachments/' . $this->findId($document),
            $document
        );
    }

    public function getAll($date = null, $args = array())
    {
        $path = '';
        $path = maybeAddDate($date, '/with-activity-since/', $path);
        $this->request->setArgs($args);
        $campaigns = $this->request->send('get', $path);
        if (count($campaigns)) {
            return new CampaignCollection($campaigns);
        } else {
            return $campaigns;
        }
    }

    public function create(Campaign $campaign)
    {
        return $this->request->send('post', '', $campaign);
    }

    public function update(Campaign $campaign)
    {
        return $this->request->send('put', '/' . $this->findId($campaign), $campaign);
    }
}
