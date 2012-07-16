<?php

namespace Banner\OrderBundle\Document;

use Mastop\SystemBundle\Document\BaseRepository;

class DiscountRepository extends BaseRepository
{

    /**
     * Pega todos ordenado por ORDER
     *
     * @return Size ou null
     **/
    public function findAllById()
    {
        return $this->findBy(array(), array('id'=>'asc'));
    }
}