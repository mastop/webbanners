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

}
