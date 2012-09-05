<?php

namespace Banner\OrderBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Representa os tamanhos padrões para banners
 * 
 * @ODM\Document(
 *   collection="size",
 *   repositoryClass="Banner\OrderBundle\Document\SizeRepository"
 * )
 */
 
class Size
{
    /**
     * ID do Tamanho
     *
     * @var string
     * @ODM\Id(strategy="increment")
     */
    protected $id;
    
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
     * Ordem
     *
     * @var int
     * @ODM\Int
     */
    protected $order;

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
     * Get id
     *
     * @return custom_id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set order
     *
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return int $order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
