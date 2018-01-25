<?php
namespace EcommerceBundle\Services;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ResearchProductForm extends AbstractType{

  /*public function __construct($ff){
    $this->formFactory = $ff;
  }*/

public function buildForm(FormBuilderInterface $builder, array $options){

    $builder
      ->add('name', TextType::class, array('required'=>false,))
      ->add('priceMin', NumberType::class, array('required'=>false,))
      ->add('priceMax', NumberType::class, array('required'=>false,))
      ->add('category', ChoiceType::class, array(
        'choices' => array(
          'Aucune'=>'NULL',
          'Electronics' => array(
            'Computer' => 'Computer',
            'Tablet' => 'Tablet',
            'SmartPhone' => 'SmartPhone',
          ),
          'Books' => array(
            'Cooking' => 'Cooking',
            'Fantastic' => 'Fantastic',
          ),
        ),))
      ->add('save', SubmitType::class, array('label' => 'Chercher'));
    }
}
