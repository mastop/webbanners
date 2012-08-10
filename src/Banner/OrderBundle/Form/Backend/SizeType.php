<?php

namespace Banner\OrderBundle\Form\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SizeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('width', 'integer', array('label'=>'Largura'))
                ->add('height', 'integer', array('label'=>'Altura'))
                ->add('order', 'integer', array('label'=>'Ordem'))
            ;
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Size'
        );
    }

    public function getName() {
        return 'size';
    }

}