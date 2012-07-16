<?php

namespace Banner\OrderBundle\Form\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SizeType extends AbstractType {
    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('width', 'integer', array('label'=>'Largura'))
                ->add('height', 'integer', array('label'=>'Altura'))
                ->add('order', 'integer', array('label'=>'Ordem'))
            ;
    }

    public function getDefaultOptions() {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Size'
        );
    }

    public function getName() {
        return 'size';
    }

}