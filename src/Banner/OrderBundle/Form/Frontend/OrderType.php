<?php

namespace Banner\OrderBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OrderType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('name', 'text', array('label' => 'Nome do Projeto', 'attr'  => array('style' => 'width: 3')))
                ->add('notes', 'textarea', array('label' => 'Anotações', 'attr'  => array('style' => 'width: 3')))
                ->add('quantity', 'number', array('label'=>'Quantidade', 'read_only'=>'true'))
            ;
    }

    public function getDefaultOptions() {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Order'
        );
    }

    public function getName() {
        return 'order';
    }

}