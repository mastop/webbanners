<?php
namespace Banner\OrderBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UploadType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
        ->add('file', 'file', array('label'=>'Arquivo','required' =>'', 'attr'=>array('onChange'=>'upload()')));
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Banner\OrderBundle\Document\Upload'
        );
    }

    public function getName() {
        return 'upload';
    }

}
