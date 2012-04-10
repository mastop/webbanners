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
     * Local onde o arquivo será salvo
     * 
     * @ODM\String
     */
    protected $uniqpath;
    
    /**
     * @ODM\String
     */
    protected $path;
    
    protected $file;
    
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
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->setPath(uniqid().'.'.$this->getfile()->guessExtension());
        }
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
     * Set file
     *
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     */
    public function getFile()
    {
        return $this->file;
    }
}
