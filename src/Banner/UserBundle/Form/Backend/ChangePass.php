<?php

namespace Banner\UserBundle\Form\Backend;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class ChangePass extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('id', 'hidden')
                ->add('password', 'password', array( 'label' => 'Senha'))
                ->add('password2', 'password', array('property_path' => false, 'label' => 'Repita a senha'))
        ;
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Banner\UserBundle\Document\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => 'novo_usuario',
        );
    }

    public function getName() {
        return 'Userform';
    }

}