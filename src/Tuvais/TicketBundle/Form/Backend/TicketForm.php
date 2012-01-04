<?php

namespace Tuvais\TicketBundle\Form\Backend;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;

class TicketForm extends AbstractType {


    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('id', 'hidden')
        ;
    }
    
}