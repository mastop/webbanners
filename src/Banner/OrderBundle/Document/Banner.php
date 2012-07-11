<?php

namespace Banner\OrderBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Representa um Pedido
 * 
 * @ODM\EmbeddedDocument
 */
 
class Banner
{
    
    /**
     * Largura
     *
     * @var int
     * @ODM\Int
     */
    protected $width;

    /**
     * Altura
     *
     * @var int
     * @ODM\Int
     */
    protected $height;

    /**
     * PSD
     *
     * @var boolean
     * @ODM\Boolean
     */
    protected $psd;

    /**
     * Foi pago?
     *
     * @var boolean
     * @ODM\Boolean
     */
    protected $paid;
    
    /**
     * Valor
     *
     * @var float
     * @ODM\Float
     */
    protected $value;
    
   

    /**
     * Set width
     *
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Get width
     *
     * @return int $width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Get height
     *
     * @return int $height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set psd
     *
     * @param boolean $psd
     */
    public function setPsd($psd)
    {
        $this->psd = $psd;
    }

    /**
     * Get psd
     *
     * @return boolean $psd
     */
    public function getPsd()
    {
        return $this->psd;
    }


    /**
     * Set value
     *
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return float $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * Get paid
     *
     * @return boolean $paid
     */
    public function getPaid()
    {
        return $this->paid;
    }
}
