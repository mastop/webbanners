<?php

namespace Banner\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
use Banner\CoreBundle\Document\Coordinates;

/**
 * Representa uma cidade
 *
 * @author   Fernando Santos <o@fernan.do>
 *
 * @ODM\Document(
 *   collection="city",
 *   repositoryClass="Banner\CoreBundle\Document\CityRepository"
 * )
 * @ODM\Indexes({
 *   @ODM\Index(keys={"special"="desc", "order"="asc", "name"="asc"})
 * })
 */
class City {

    /**
     * ID da Cidade
     *
     * @var string
     * @ODM\Id
     */
    protected $id;

    /**
     * Nome da Cidade
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
     * Ordem
     *
     * @var string
     * @ODM\Int
     */
    protected $order = 0;

    /**
     * Destaque
     *
     * @var string
     * @ODM\Boolean
     */
    protected $special = false;

    /**
     * Estado
     *
     * @var string
     * @ODM\string
     */
    protected $state;

    /**
     * Coordenadas
     * 
     * 
     * @var float
     *  @ODM\EmbedOne( targetDocument ="Banner\CoreBundle\Document\Coordinates") 
     */
    protected $coordinates;

    public function isSpecial() {
        return ($this->getSpecial()) ? "Sim" : "Não";
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug) {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set order
     *
     * @param int $order
     */
    public function setOrder($order) {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return int $order
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * Set special
     *
     * @param boolean $special
     */
    public function setSpecial($special) {
        $this->special = $special;
    }

    /**
     * Get special
     *
     * @return boolean $special
     */
    public function getSpecial() {
        return $this->special;
    }

    /**
     * Set state
     *
     * @param string $state
     */
    public function setState($state) {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return string $state
     */
    public function getState() {
        return $this->state;
    }


    /**
     * Set coordinates
     *
     * @param Banner\CoreBundle\Document\Coordinates $coordinates
     */
    public function setCoordinates(\Banner\CoreBundle\Document\Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    /**
     * Get coordinates
     *
     * @return Banner\CoreBundle\Document\Coordinates $coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }
}
