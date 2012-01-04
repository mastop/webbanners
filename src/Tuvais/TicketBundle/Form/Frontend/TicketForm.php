<?php

namespace Tuvais\TicketBundle\Form\Frontend;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\AbstractType;

class TicketForm extends AbstractType {

    protected $name;

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('id', 'hidden');
                }
}