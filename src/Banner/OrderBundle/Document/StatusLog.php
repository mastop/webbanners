<?php

namespace Banner\OrderBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Description of StatusLog
 *
 * @ODM\EmbeddedDocument
 */
class StatusLog
{
    /**
     * Mongo id
     * 
     * @var MongoId
     * @ODM\Id
     */
    protected $id;
    
    /**
     * Usuário que editou o status
     * 
     * @var object
     * @ODM\ReferenceOne(targetDocument="Banner\UserBundle\Document\User")
     */
    protected $user;
    
    /**
     * Status
     * 
     * @var object
     * @ODM\ReferenceOne(targetDocument="Banner\OrderBundle\Document\Status")
     */
    protected $status;
    
    /**
     * Data de Criação
     *
     * @var object
     * @ODM\Date
     */
    protected $created;
        
    /**
     * Prepersist para setar o created
     * 
     * @ODM\prePersist
     */
    public function prePersist()
    {
        $this->setCreated(new \DateTime());
    }

   

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param Banner\UserBundle\Document\User $user
     */
    public function setUser(\Banner\UserBundle\Document\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Banner\UserBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set status
     *
     * @param Banner\OrderBundle\Document\Status $status
     */
    public function setStatus(\Banner\OrderBundle\Document\Status $status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return Banner\OrderBundle\Document\Status $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param date $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return date $created
     */
    public function getCreated()
    {
        return $this->created;
    }
}
