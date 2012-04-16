<?php
namespace Banner\OrderBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UploadType extends AbstractType {
    public function buildForm(FormBuilder $builder, array $options) {
        $builder
        ->add('file', 'file', array('label'=>'Arquivo','required' =>'', 'attr'=>array('onChange'=>'upload()')));
    }

    public function getDefaultOptions() {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Upload'
        );
    }

    public function getName() {
        return 'upload';
    }

}
