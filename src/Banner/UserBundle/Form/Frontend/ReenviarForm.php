<?php

namespace Banner\UserBundle\Form\Frontend;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class ReenviarForm extends AbstractType {

    protected $email;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', 'email', array('label' => 'Informe seu email'))

        ;
    }


    public function getName() {
        return 'Reenviarform';
    }

}