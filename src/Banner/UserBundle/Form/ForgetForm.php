<?php

namespace Banner\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class ForgetForm extends AbstractType {

    protected $email;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', 'email', array('label' => 'Email'))
        ;
    }

    public function getName() {
        return 'Forgetform';
    }

}