<?php

namespace Banner\OrderBundle\Document;

use Mastop\SystemBundle\Document\BaseRepository;

class SizeRepository extends BaseRepository
{

    /**
     * Pega todos ordenado por ORDER
     *
     * @return Size ou null
     **/
    public function findAllByOrder()
    {
        return $this->findBy(array(), array('order'=>'asc'));
    }
}