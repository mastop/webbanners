<?php

namespace Banner\OrderBundle\Form\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StatusType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array('label'=>'Nome'))
                ->add('order', 'integer', array('label'=>'Ordem'))
            ;
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Status'
        );
    }

    public function getName() {
        return 'status';
    }

}