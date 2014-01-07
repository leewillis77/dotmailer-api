<?php

namespace Dotmailer\Entity;

/**
 * A contact import report record.
 * http://api.dotmailer.com/v2/help/wadl#ApiContactImportReport
 *
 * @extends Dotmailer\Entity
 */
class ContactImportReport extends Entity
{
  protected $newContacts;
  protected $updatedContacts;
  protected $globallySuppressed;
  protected $invalidEntries;
  protected $duplicateEmails;
  protected $blocked;
  protected $unsubscribed;
  protected $hardBounced;
  protected $softBounced;
  protected $ispComplaints;
  protected $mailBlocked;
  protected $domainSuppressed;
  protected $pendingDoubleOptin;
  protected $failures;
}
