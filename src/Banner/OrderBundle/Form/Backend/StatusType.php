<?php

namespace Banner\OrderBundle\Form\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class StatusType extends AbstractType {
    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('name', 'text', array('label'=>'Nome'))
                ->add('order', 'integer', array('label'=>'Ordem'))
            ;
    }

    public function getDefaultOptions() {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Status'
        );
    }

    public function getName() {
        return 'status';
    }

}