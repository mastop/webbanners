<?php

namespace Banner\UserBundle\Form\Frontend;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\AbstractType;

class ChangePassForm extends AbstractType {

    protected $password;
    protected $password2;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('password', 'password', array('label' => 'Senha'))
                ->add('password2', 'password', array('label' => 'Repita a senha'))
        ;
    }

    public function getName() {
        return 'ChangePass';
    }

}