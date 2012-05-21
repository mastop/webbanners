<?php

namespace Banner\OrderBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Representa um Pedido
 *
 * @ODM\Document(
 *   collection="order",
 *   repositoryClass="Banner\OrderBundle\Document\OrderRepository"
 * )
 * @ODM\Indexes({
 * @ODM\Index(keys={"id"="asc", "name"="asc"})
 * })
 */
class Order
{
    /**
     * ID do Pedido
     *
     * @var string
     * @ODM\Id(strategy="increment")
     */
    protected $id;

    /**
     * Usuário
     *
     * @var object
     * @ODM\ReferenceOne(targetDocument="Banner\UserBundle\Document\User")
     */
    protected $user;

    /**
     * Designer
     *
     * @var object
     * @ODM\ReferenceOne(targetDocument="Banner\UserBundle\Document\User")
     */
    protected $designer;
    
    /**
     * Nome do projeto
     * 
     * @var string
     * @ODM\String
     * @ODM\UniqueIndex
     */
    protected $name;
    
    /**
     * Anotações do pedido
     * 
     * @var string
     * @ODM\String
     */
    protected $notes;
    
    /**
     * Anotações do pedido
     * 
     * @var string
     * @ODM\String
     */
    protected $link;
    
    /**
     * Pedido aprovado
     * 
     * @var string
     * @ODM\String
     */
    protected $aproved;
    
    /**
     * Array com as informações sobre o pagamento
     * 
     * @var array
     * @ODM\Hash
     */
    protected $payment = array();

    /**
     * Total do valor gasto no pedido
     * 
     * @var float
     * @ODM\Float
     */
    protected $total;
    
    /**
     * Data de Criação
     *
     * @var object
     * @ODM\Date
     */
    protected $created;

    /**
     * Data de Expiração
     *
     * @var object
     * @ODM\Date
     */
    protected $expires;
    
    /**
     * Data de Atualização
     *
     * @var object
     * @ODM\Date
     */
    protected $updated;
    
    /**
     * Status
     * 
     * @var object
     * @ODM\ReferenceOne(targetDocument="Banner\OrderBundle\Document\Status")
     */
    protected $status;
    
    /**
     * Guarda o histórico dos status do pedido
     * 
     * @var object
     * @ODM\EmbedMany(targetDocument="Banner\OrderBundle\Document\StatusLog")
     */
    protected $statusLog;
    
    /**
     * Upload
     *
     * @var object
     * @ODM\EmbedMany(targetDocument="Banner\OrderBundle\Document\Upload")
     */
    protected $upload = array();
    
    /**
     * Linguagem Visual
     *
     * @var object
     * @ODM\EmbedMany(targetDocument="Banner\OrderBundle\Document\Upload")
     */
    protected $vLanguage = array();
    
    /**
     * Figuras para desenvolver o Banner
     * 
     * @var object
     * @ODM\EmbedMany(targetDocument="Banner\OrderBundle\Document\Banner")
     */
    protected $banner;
    
    /**
     * Quantidade vendida
     *
     * @var int
     * @ODM\Int
     */
    protected $quantity;
    /**
     * mensagens não lidas cliente
     *
     * @var int
     * @ODM\Int
     */
    protected $cunread;

    /**
     * mensagens não lidas designer
     *
     * @var int
     * @ODM\Int
     */
    protected $dunread;
    
    /**
     * Conversa
     * 
     * @var array
     * @ODM\EmbedMany(targetDocument="Banner\OrderBundle\Document\Talk")
     */
    protected $talk = array();
    
    /**
     * Envios de banners
     * 
     * @var array
     * @ODM\EmbedMany(targetDocument="Banner\OrderBundle\Document\Upload")
     */
    protected $preview = array();
    
    /**
     * Upload do arquivo final
     * 
     * @var array
     * @ODM\EmbedOne(targetDocument="Banner\OrderBundle\Document\Upload")
     */
    protected $final;
    
    /**
     * Dados do usuário, exemplo: Ip. Origem, OS, etc
     * 
     * @var array
     * @ODM\Hash
     */
    protected $userData;
    

    /** 
     * @ODM\PrePersist 
     */
    public function doPrePersist()
    {
        $this->setCreated(new \DateTime);
        $now   = (new \DateTime);
        $now->modify( '+1 year' );
        $this->setExpires($now);
    }
    /** 
     * @ODM\PreUpdate
     */
    public function doPreUpdate()
    {
        $this->setUpdated(new \DateTime);
        $now   = (new \DateTime);
        $now->modify( '+1 year' );
        $this->setExpires($now);
    }

    public function __construct()
    {
        $this->statusLog = new \Doctrine\Common\Collections\ArrayCollection();
        $this->upload = new \Doctrine\Common\Collections\ArrayCollection();
        $this->talk = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preview = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return int $id
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
     * Set designer
     *
     * @param Banner\UserBundle\Document\User $designer
     */
    public function setDesigner(\Banner\UserBundle\Document\User $designer)
    {
        $this->designer = $designer;
    }

    /**
     * Get designer
     *
     * @return Banner\UserBundle\Document\User $designer
     */
    public function getDesigner()
    {
        return $this->designer;
    }

    /**
     * Set notes
     *
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get notes
     *
     * @return string $notes
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set payment
     *
     * @param hash $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get payment
     *
     * @return hash $payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set total
     *
     * @param float $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * Get total
     *
     * @return float $total
     */
    public function getTotal()
    {
        return $this->total;
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
     * Set updated
     *
     * @param date $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return date $updated
     */
    public function getUpdated()
    {
        return $this->updated;
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
     * Add statusLog
     *
     * @param Banner\OrderBundle\Document\StatusLog $statusLog
     */
    public function addStatusLog(\Banner\OrderBundle\Document\StatusLog $statusLog)
    {
        $this->statusLog[] = $statusLog;
    }

    /**
     * Get statusLog
     *
     * @return Doctrine\Common\Collections\Collection $statusLog
     */
    public function getStatusLog()
    {
        return $this->statusLog;
    }

    /**
     * Set quantity
     *
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return int $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Add talk
     *
     * @param Banner\OrderBundle\Document\Talk $talk
     */
    public function addTalk(\Banner\OrderBundle\Document\Talk $talk)
    {
        $this->talk[] = $talk;
    }

    /**
     * Get talk
     *
     * @return Doctrine\Common\Collections\Collection $talk
     */
    public function getTalk()
    {
        return $this->talk;
    }

    /**
     * Add preview
     *
     * @param Banner\OrderBundle\Document\Upload $preview
     */
    public function addPreview(\Banner\OrderBundle\Document\Upload $preview)
    {
        $this->preview[] = $preview;
    }

    /**
     * Get preview
     *
     * @return Doctrine\Common\Collections\Collection $preview
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * Set userData
     *
     * @param hash $userData
     */
    public function setUserData($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Get userData
     *
     * @return hash $userData
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * Add banner
     *
     * @param Banner\OrderBundle\Document\Banner $banner
     */
    public function addBanner(\Banner\OrderBundle\Document\Banner $banner)
    {
        $this->banner[] = $banner;
    }

    /**
     * Get banner
     *
     * @return Doctrine\Common\Collections\Collection $banner
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set expires
     *
     * @param date $expires
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
    }

    /**
     * Get expires
     *
     * @return date $expires
     */
    public function getExpires()
    {
        return $this->expires;
    }
    
    /**
     * Format Expires
     *
     * @return date $expires
     */
    public function formatExpires()
    {
        return date('d/m/Y',$this->expires->getTimestamp());
    }
    
    /**
     * Format Updated
     *
     * @return date $updated
     */
    public function formatUpdated()
    {
        return date('d/m/Y',$this->updated>getTimestamp());
    }
    
    /**
     * Format Created
     *
     * @return date $created
     */
    public function formatCreated()
    {
        return date('d/m/Y',$this->created->getTimestamp());
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cunread
     *
     * @param int $cunread
     */
    public function setCunread($cunread)
    {
        $this->cunread = $cunread;
    }

    /**
     * Get cunread
     *
     * @return int $cunread
     */
    public function getCunread()
    {
        return $this->cunread;
    }

    /**
     * Set dunread
     *
     * @param int $dunread
     */
    public function setDunread($dunread)
    {
        $this->dunread = $dunread;
    }

    /**
     * Get dunread
     *
     * @return int $dunread
     */
    public function getDunread()
    {
        return $this->dunread;
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

    /**
     * Set link
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Get link
     *
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Add vLanguage
     *
     * @param Banner\OrderBundle\Document\Upload $vLanguage
     */
    public function addVLanguage(\Banner\OrderBundle\Document\Upload $vLanguage)
    {
        $this->vLanguage[] = $vLanguage;
    }

    /**
     * Get vLanguage
     *
     * @return Doctrine\Common\Collections\Collection $vLanguage
     */
    public function getVLanguage()
    {
        return $this->vLanguage;
    }

    /**
     * Set aproved
     *
     * @param string $aproved
     */
    public function setAproved($aproved)
    {
        $this->aproved = $aproved;
    }

    /**
     * Get aproved
     *
     * @return string $aproved
     */
    public function getAproved()
    {
        return $this->aproved;
    }

    /**
     * Set final
     *
     * @param Banner\OrderBundle\Document\Upload $final
     */
    public function setFinal(\Banner\OrderBundle\Document\Upload $final)
    {
        $this->final = $final;
    }

    /**
     * Get final
     *
     * @return Banner\OrderBundle\Document\Upload $final
     */
    public function getFinal()
    {
        return $this->final;
    }
}
