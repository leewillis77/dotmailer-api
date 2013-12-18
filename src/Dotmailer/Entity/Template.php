<?php

namespace Dotmailer\Entity;

/**
 * A template record.
 * http://api.dotmailer.com/v2/help/wadl#ApiTemplate
 *
 * @extends Dotmailer\Entity
 */
class Template extends Entity
{
    protected $id;
    public $name;
    public $subject;
    public $fromName;
    public $htmlContent;
    public $plainTextContent;
    public $replyAction;
    public $replyToAddress;
}
