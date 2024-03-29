<?php

namespace Banner\UserBundle\Form\Frontend;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\AbstractType;

class UserForm extends AbstractType {

    protected $name;
    protected $email;
    protected $password;
    protected $password2;
    protected $username;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('id', 'hidden')
                ->add('name', 'text', array('max_length' => 100, 'label' => 'Nome Completo'))
                ->add('email', 'email', array('label' => 'Email'))
                ->add('cpf', 'text', array('label' => 'CPF', 'attr' => array('class' => 'cpfMask')))
                ->add('password', 'password', array('label' => 'Senha'))
                ->add('password2', 'password', array('property_path' => false, 'label' => 'Repita a senha'))
                ->add('agree', 'checkbox', array('label' => 'Eu li e aceito os Termos e Condições de uso do site ', 'required' => true, 'property_path' => false))
                ->add('newsletters', 'checkbox', array('label' => 'Sim, quero receber notícias e promoções do Banner ', 'required' => false))
                ->add('emailVerify', 'hidden', array('property_path' => false))

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