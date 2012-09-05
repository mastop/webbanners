<?php

namespace Banner\OrderBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * upload de arquivos
 *
 * @ODM\EmbeddedDocument
 */

class Upload {
    
    /**
     * @ODM\Id
     */
    protected $id;
    
    /**
     * Usuário que fez o upload
     * 
     * @var object
     * @ODM\ReferenceOne(targetDocument="Banner\UserBundle\Document\User")
     */
    protected $user;
    
    /**
     * Local onde o arquivo será salvo
     * 
     * @ODM\String
     */
    protected $uniqpath;
    
    /**
     * @ODM\String
     */
    protected $path;
    
    /**
     * @ODM\String
     */
    protected $justify;
    
    /**
     * @ODM\String
     */
    protected $aproved;
    
    /**
     * Nome do Arquivo
     *
     * @var string
     * @ODM\String
     */
    protected $file;
    
    /**
     * Data de Criação
     *
     * @var object
     * @ODM\Date
     */
    protected $created;
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->file;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->file;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/file in the view.
        return '/uploads/'.$this->getUniqpath();
    }
    
    /**
    * @ODM\PrePersist()
    * @ODM\PreUpdate()
    */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $this->setPath(uniqid().'.'.$this->getFile()->guessExtension());
        }
    } 
    /*
     * @ODM\prePersist
     */
    public function prePersist()
    {
        $this->setCreated(new \DateTime());
    }
     
    /**
    * @ODM\PostPersist()
    * @ODM\PostUpdate()
    */
    public function upload() {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }
    
    /**
    * @ODM\PostRemove()
    */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
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
     * Set uniqpath
     *
     * @param string $uniqpath
     */
    public function setUniqpath($uniqpath)
    {
        $this->uniqpath = $uniqpath;
    }

    /**
     * Get uniqpath
     *
     * @return string $uniqpath
     */
    public function getUniqpath()
    {
        return $this->uniqpath;
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

    /**
     * Get address
     *
     */
    public function getAddress()
    {
        return $this->getWebPath().$this->getPath();
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
     * Set justify
     *
     * @param string $justify
     */
    public function setJustify($justify)
    {
        $this->justify = $justify;
    }

    /**
     * Get justify
     *
     * @return string $justify
     */
    public function getJustify()
    {
        return $this->justify;
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
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return string $file
     */
    public function getFile()
    {
        return $this->file;
    }
}
