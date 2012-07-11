<?php

namespace Banner\OrderBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OrderType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('name', 'text', array('label' => 'Nome do Projeto'))
                ->add('link', 'text', array('label' => 'Para qual pagina o seu banner irá direcionar?'))
                ->add('text', 'textarea', array('label' => 'Qual texto você gostaria que aparecesse no Banner?'))
                ->add('notes', 'textarea', array('label' => 'Digite as instruções que gostaria que os designers seguisse.'))
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