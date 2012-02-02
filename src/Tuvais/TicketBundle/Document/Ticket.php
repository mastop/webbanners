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
    /**
     * Id do ingresso
     * 
     * @ODM\Id 
     */
    protected $id;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
}
