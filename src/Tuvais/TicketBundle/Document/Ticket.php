<?php

namespace Tuvais\TicketBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ODM\Document (
 * collection="ticket",
 * repositoryClass="Tuvais\TicketBundle\Document\TicketRepository"
 * ) 
 */
class Ticket {
}
