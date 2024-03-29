<?php

namespace Banner\OrderBundle\Form\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DiscountType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('description', 'text', array('label'=>'Descrição'))
                ->add('discount', 'integer', array('label'=>'Desconto'))
                ->add('type', 'choice', array('label'=>'Tipo de Desconto', 'choices' => array('porcentagem' => 'Porcentagem', 'valor' => 'Valor')))
                ->add('expires', 'date', array('label'=>'Validade'))
                ->add('limit', 'integer', array('label'=>'Limite de Usos'))
            ;
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Discount'
        );
    }

    public function getName() {
        return 'Discount';
    }

}