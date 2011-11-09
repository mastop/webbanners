<?php

namespace Tuvais\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Tuvais\CoreBundle\Document\City;

class CityEditType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('id', 'hidden');
        $builder->add('name', 'text', array('label'=>'Nome'));
        $builder->add('state', 'text', array('label'=>'Estado'));
        $builder->add('special', 'checkbox', array(
            'label' => 'Exibir em "Principais Cidades"?',
            'required' => false,
        ));
        $builder->add('order', 'text', array('label'=>'Ordem', 'attr'=>array('class'=>'small')));
        $builder->add('coordinates', new CoordinatesType(), array('label'=>'Coordenadas'));
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Tuvais\CoreBundle\Document\City',
            'intention' => 'city_creation',
        );
    }

    public function getName() {
        return 'city';
    }

}
