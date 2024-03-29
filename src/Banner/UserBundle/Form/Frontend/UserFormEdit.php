<?php

namespace Banner\UserBundle\Form\Frontend;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\AbstractType;

class UserFormEdit extends AbstractType {

    protected $name;
    protected $email;
    protected $username;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('id', 'hidden')
                ->add('name', 'text', array('max_length' => 100, 'label' => 'Nome Completo'))
                ->add('email', 'email', array('label' => 'Email'))
                ->add('cpf', 'text', array('label' => 'CPF'))

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
        return 'Userformedit';
    }

}