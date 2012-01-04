<?php

namespace Tuvais\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Representa um banner
 *
 * @author   Fernando Santos <o@fernan.do>
 *
 * @ODM\Document(
 *   collection="banner",
 *   repositoryClass="Tuvais\CoreBundle\Document\BannerRepository"
 * )
 */
class Banner
{
    /**
     * ID do banner
     *
     * @var mongoId
     * @ODM\Id
     */
    protected $id;
    
    /**
     * Title do banner
     * 
     * @var string
     * @ODM\String
     */
    protected $title;
    
    /**
     * Link para onde o banner vai apontar
     * 
     * @var string
     * @ODM\String
     */
    protected $url;
    
    /**
     * Nova Janela?
     *
     * @var string
     * @ODM\Boolean
     */
    protected $newWindow = false;
    
    /**
     * Ordem
     * 
     * @var Int
     * @ODM\Int
     */
    protected $order = 0;

    /**
     * Ativo
     * 
     * @var string
     * @ODM\Boolean
     */
    protected $active = true;

    /**
     * Cidade do Banner
     *
     * @ODM\ReferenceOne(targetDocument="Tuvais\CoreBundle\Document\City")
     * @ODM\Index
     */
    protected $city;
    
    /**
     * Nome do Arquivo
     *
     * @var string
     * @ODM\String
     */
    protected $filename;
    
    /**
     * Tamanho do Arquivo
     *
     * @var string
     * @ODM\String
     */
    protected $filesize;
    
    /**
     * Path d Arquivo
     *
     * @var string
     * @ODM\String
     */
    protected $path;

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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set newWindow
     *
     * @param boolean $newWindow
     */
    public function setNewWindow($newWindow)
    {
        $this->newWindow = $newWindow;
    }

    /**
     * Get newWindow
     *
     * @return boolean $newWindow
     */
    public function getNewWindow()
    {
        return $this->newWindow;
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
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set city
     *
     * @param Tuvais\CoreBundle\Document\City $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return Tuvais\CoreBundle\Document\City $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set filename
     *
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get filename
     *
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set filesize
     *
     * @param string $filesize
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;
    }

    /**
     * Get filesize
     *
     * @return string $filesize
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }
}
