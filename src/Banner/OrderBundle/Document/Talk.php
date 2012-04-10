<?php

namespace Banner\OrderBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Representa uma conversação
 *
 * @ODM\EmbeddedDocument
 */
class Talk
{
    /**
     * Usuário
     *
     * @ODM\ReferenceOne(targetDocument="Banner\UserBundle\Document\User")
     */
    protected $user;
    
    /**
     * Mensagem
     *
     * @var string
     * @ODM\String
     */
    protected $message;
    
    /**
     * Data
     *
     * @var object
     * @ODM\Date
     */
    protected $created;
       
    /**
     * Upload
     *
     * @var object
     * @ODM\EmbedMany(targetDocument="Banner\OrderBundle\Document\Upload")
     */
    protected $upload = array();
    
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
     * Format Created
     *
     * @return date $created
     */
    public function formatCreated()
    {
        return date('d-m-Y H:i',$this->created->getTimestamp());
    }
    public function __construct()
    {
        $this->upload = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
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


    /**
     * Add upload
     *
     * @param Banner\OrderBundle\Document\Upload $upload
     */
    public function addUpload(\Banner\OrderBundle\Document\Upload $upload)
    {
        $this->upload[] = $upload;
    }

    /**
     * Get upload
     *
     * @return Doctrine\Common\Collections\Collection $upload
     */
    public function getUpload()
    {
        return $this->upload;
    }
}
