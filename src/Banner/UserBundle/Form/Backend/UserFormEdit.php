<?php

namespace Banner\UserBundle\Form\Backend;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class UserFormEdit extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('id', 'hidden')
                ->add('name', 'text', array('max_length' => 100, 'label' => 'Nome', 'required' => false))
                ->add('email', 'email', array('label' => 'Email'))
                ->add('cpf', 'text', array('label' => 'CPF', 'required' => false))
                ->add('roles', 'choice', array('property_path' => false, 'choices' => array('ROLE_USER' => 'Usuário', 'ROLE_DESIGNER' => 'Designer', 'ROLE_ADMIN' => 'Administrador'), 'required' => true, 'label' => 'Grupo'))
                ->add('status', 'choice', array('label' => 'Ativo', 'required' => true,
                    'choices' => array('1' => 'Sim', '2' => 'Não')))

        ;
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Banner\UserBundle\Document\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => 'editar_usuario',
        );
    }

    public function getName() {
        return 'Userformedit';
    }

}