<?php

namespace Banner\UserBundle\Form\Frontend;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\AbstractType;

class UserFormTwitter extends AbstractType {

    protected $email;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', 'email', array('label' => 'Email'))
                ->add('agree', 'checkbox', array('label' => 'Eu li e aceito os Termos e Condições de uso do Banner', 'required' => true, 'property_path' => false))
                ->add('newsletters', 'checkbox', array('label' => 'Sim, quero receber notícias e promoções do Banner', 'required' => false))
                ->add('emailVerify', 'hidden', array('property_path' => false))

        ;
    }

    public function getName() {
        return 'UserformTwitter';
    }

}