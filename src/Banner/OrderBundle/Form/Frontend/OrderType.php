<?php

namespace Banner\OrderBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OrderType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('user', 'document', array('label'=>'Usuario', 'class' => 'BannerUserBundle:User', 'property'=>'name', 'choices' => $options['dm'], 'read_only' => 'true'))
                ->add('designer', 'document', array('label'=>'Designer','required' =>'false', 'class' => 'BannerUserBundle:User', 'property'=>'name', 'choices' => $options['dm'], 'empty_value' => 'Escolha um designer'  ))
                ->add('name', 'text', array('label' => 'Nome do Projeto', 'attr'  => array('style' => 'width: 3')))
                ->add('notes', 'textarea', array('label' => 'Anotações', 'attr'  => array('style' => 'width: 3')))
                ->add('quantity', 'number', array('label'=>'Quantidade', 'read_only'=>'true'))
            ;
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Order',
            'intention' => 'order_creation',
            'em' => '',
            'dm' => 'crawler',
        );
    }

    public function getName() {
        return 'order';
    }

}