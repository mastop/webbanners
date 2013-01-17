<?php

namespace Banner\OrderBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array('label' => 'Nome do Projeto'))
                ->add('link', 'text', array('label' => 'Para qual pagina o seu banner irá direcionar?'))
                ->add('text', 'textarea', array('label' => 'Qual texto você gostaria que aparecesse no Banner?'))
                ->add('notes', 'textarea', array('label' => 'Digite as instruções que gostaria que os designers seguisse.'))
                ->add('quantity', 'hidden')
                ->add('cupom', 'text', array('label'=>'Cupom de desconto','required' =>'', 'attr'  => array('style' => 'width: 150px')))
                ->add('total','money',array('label'=>'Total', 'currency'=>'BRL', 'read_only'=>'read_only'))
            ;
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Order'
        );
    }

    public function getName() {
        return 'order';
    }

}