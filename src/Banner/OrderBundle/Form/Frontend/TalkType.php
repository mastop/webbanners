<?php
namespace Banner\OrderBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TalkType extends AbstractType {
    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('message', 'textarea', array('label'=>'Resposta'))
        ;
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Talk'
        );
    }

    public function getName() {
        return 'talk';
    }

}