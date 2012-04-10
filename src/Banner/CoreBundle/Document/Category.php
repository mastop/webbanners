<?php

namespace Banner\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Representa uma Categoria
 * 
 * @author   Guilherme Turri <guilherme@mastop.com.br>
 *
 * @ODM\Document(
 *   collection="category",
 *   repositoryClass="Banner\CoreBundle\Document\CategoryRepository"
 * )
 * @ODM\Indexes({
 * @ODM\Index(keys={"order"="asc", "name"="asc"})
 * })
 */

class Category {

    /**
     *  ID da Categoria
     * 
     * @var string
     * @ODM\Id
     * 
     */
    protected $id;

    /**
     * Nome da Categoria
     * 
     * @var string
     * @ODM\String
     */
    protected $name;

    /**
     * Campo Slug
     *
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ODM\UniqueIndex
     * @ODM\String
     */
    protected $slug;

    /**
     * Especial
     *
     * @var bool
     * @ODM\Boolean
     * 
     */
    protected $special;

    /**
     * Ordem
     *
     * @var string
     * @ODM\Int
     */
    protected $order = 0;

    /**
     * Subcategorias
     * 
     * 
     * @var string
     *  @ODM\ReferenceOne(targetDocument ="Category") 
     */
    protected $parent;
    
    /**
     * Visível
     *
     * @var bool
     * @ODM\Boolean
     * 
     */
    protected $visible;

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
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set special
     *
     * @param boolean $special
     */
    public function setSpecial($special)
    {
        $this->special = $special;
    }

    /**
     * Get special
     *
     * @return boolean $special
     */
    public function getSpecial()
    {
        return $this->special;
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

    /**
     * Set parent
     *
     * @param Banner\CoreBundle\Document\Category $parent
     */
    public function setParent(\Banner\CoreBundle\Document\Category $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Banner\CoreBundle\Document\Category $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * Get visible
     *
     * @return boolean $visible
     */
    public function getVisible()
    {
        return $this->visible;
    }
}
