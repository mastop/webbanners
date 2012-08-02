<?php

namespace Banner\OrderBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Representa um Pedido
 *
 * @ODM\Document(
 *   collection="Discount",
 *   repositoryClass="Banner\OrderBundle\Document\DiscountRepository"
 * )
 * @ODM\Indexes({
 * @ODM\Index(keys={"id"="asc", "name"="asc"})
 * })
 */
class Discount
{
    /**
     * ID do Pedido
     *
     * @var string
     * @ODM\Id(strategy="increment")
     */
    protected $id;
    
    /**
     * Código do disconto
     * 
     * @ODM\String
     */
    protected $code;

    /**
     * Descrição
     *
     * @var string
     * @ODM\String
     */
    protected $description;

    /**
     * Desconto
     *
     * @var float
     * @ODM\Float
     */
    protected $discount;
    
    /**
     * Tipo de desconto (real, porcentagem)
     *
     * @var string
     * @ODM\String
     */
    protected $type;
    
    /**
     * Validade do cupom
     *
     * @var date
     * @ODM\Date
     */
    protected $expires;
    
    /**
     * Usos
     *
     * @var integer
     * @ODM\Int
     */
    protected $uses;
    
    /**
     * Limite
     *
     * @var integer
     * @ODM\Int
     */
    protected $limit;

    /**
     * Get id
     *
     * @return custom_id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set discount
     *
     * @param float $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * Get discount
     *
     * @return float $discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
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
     * Set uses
     *
     * @param int $uses
     */
    public function setUses($uses)
    {
        $this->uses = $uses;
    }

    /**
     * Get uses
     *
     * @return int $uses
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * Set limit
     *
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * Get limit
     *
     * @return int $limit
     */
    public function getLimit()
    {
        return $this->limit;
    }
    
    public function isValid()
    {
        return "Sim";
    }
    
    public function getValue($total)
    {
        return $this->limit;
    }

    /**
     * Set code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }
}
