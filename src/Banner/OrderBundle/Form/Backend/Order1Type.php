<?php

namespace Banner\OrderBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Order1Type extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('name', 'text', array('label' => 'Nome do Projeto', 'read_only'=>'true', 'attr'  => array('style' => 'width: 3')))
                ->add('link', 'textarea', array('label' => 'Link', 'read_only'=>'true', 'attr'  => array('style' => 'width: 3')))
                ->add('notes', 'textarea', array('label' => 'Anotações','read_only'=>'true', 'attr'  => array('style' => 'width: 3')))
                ->add('quantity', 'number', array('label'=>'Quantidade', 'read_only'=>'true'))
                ->add('cupom', 'text', array('label'=>'Cupom de desconto', 'attr'  => array('style' => 'width: 3')))
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