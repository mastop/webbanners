<?php

namespace Banner\OrderBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OrderType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('name', 'text', array('label' => 'Nome do Projeto', 'attr'  => array('style' => 'width: 3')))
                ->add('link', 'textarea', array('label' => 'Link', 'attr'  => array('style' => 'width: 3')))
                ->add('notes', 'textarea', array('label' => 'Anotações', 'attr'  => array('style' => 'width: 3')))
                ->add('quantity', 'hidden')
                ->add('total','money',array('label'=>'Total', 'currency'=>'R$', 'read_only'=>'read_only'))
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